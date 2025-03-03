<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdsbData;
use App\Models\AdsbDataAircraft;
use App\Models\AdsbDataFlight;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\Datalogger;
use App\Models\DataTransferLog;
use App\Models\RadarData;
use App\Models\Sensor;
use App\Models\SensorData;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Distance\Vincenty;
use Illuminate\Support\Facades\Cache;

class AISDataController extends Controller
{
    public function isValidLatitude($latitude)
    {
        return is_numeric($latitude) && $latitude >= -90 && $latitude <= 90;
    }

    public function isValidLongitude($longitude)
    {
        return is_numeric($longitude) && $longitude >= -180 && $longitude <= 180;
    }

    public function aisdata()
    {
        if (empty(request()->source)) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        // Create cache key based on request data
        $cacheKey = 'ais_data_' . md5(json_encode(request()->all()));
        
        // Check if data was recently processed (5 seconds cache)
        if (Cache::has($cacheKey)) {
            return response()->json([
                'aisData' => Cache::get($cacheKey),
                'cached' => true
            ], 201);
        }

        try {
            DB::beginTransaction();

            // Cache sensor lookup for 1 hour since it rarely changes
            $sensor = Cache::remember('sensor_1', 3600, function() {
                return Sensor::find(1);
            });

            $sensorData = new SensorData([
                'sensor_id' => $sensor->id,
                'payload' => request()->source,
                'timestamp' => Carbon::parse(request()->isoDate),
            ]);
            $sensorData->save();

            if (request()->mmsi) {
                $vessel = AisDataVessel::updateOrCreate(['mmsi' => request()->mmsi]);

                $latitude = request()->latitude;
                $longitude = request()->longitude;
                
                if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
                    // Cache datalogger position for 5 minutes
                    $datalogger = Cache::remember('datalogger_1', 300, function() {
                        return Datalogger::find(1);
                    });

                    $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
                    $coordinate2 = new Coordinate($latitude, $longitude);
                    $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                    $distanceInNauticalMiles = ($distance / 1000) * 0.539957;

                    $vesselPosition = new AisDataPosition([
                        'sensor_data_id' => $sensorData->id,
                        'vessel_id' => $vessel->id,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'speed' => request()->speedOverGround,
                        'course' => request()->courseOverGround,
                        'heading' => request()->trueHeading,
                        'navigation_status' => request()->navigationStatus,
                        'turning_rate' => request()->turningRate ?? request()->rateOfTurn,
                        'turning_direction' => request()->turningDirection,
                        'timestamp' => Carbon::parse(request()->isoDate),
                        'distance' => $distanceInNauticalMiles,
                    ]);
                    $vesselPosition->save();
                }
            } else if (request()->senderMmsi) {
                $vessel = AisDataVessel::updateOrCreate(
                    ['mmsi' => request()->senderMmsi],
                    [
                        'vessel_name' => request('name'),
                        'vessel_type' => request('shipType_text'),
                        'imo' => request('shipId'),
                        'callsign' => request('callsign'),
                        'draught' => request('draught'),
                        'reported_destination' => request('destination'),
                        'dimension_to_bow' => request('dimensionToBow'),
                        'dimension_to_stern' => request('dimensionToStern'),
                        'dimension_to_port' => request('dimensionToPort'),
                        'dimension_to_starboard' => request('dimensionToStarboard'),
                        'reported_eta' => Carbon::parse(request('eta')),
                        'type_number' => request('type_number'),
                    ]
                );
            }

            $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
                ->orderBy('created_at', 'DESC')
                ->groupBy('vessel_id')
                ->where('id', $vesselPosition->id)
                ->first();

            DB::commit();

            // Cache the result for 5 seconds
            Cache::put($cacheKey, $aisData, 5);

            return response()->json([
                'aisData' => $aisData,
                'cached' => false
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error processing AIS data: ' . $e->getMessage()
            ], 500);
        }
    }
}
