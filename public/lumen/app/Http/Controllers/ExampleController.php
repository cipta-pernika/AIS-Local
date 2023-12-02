<?php

namespace App\Http\Controllers;

use App\Models\AisDataVessel;
use App\Models\Datalogger;
use App\Models\EventTracking;
use App\Models\Sensor;
use App\Models\SensorData;
use Carbon\Carbon;

class ExampleController extends Controller
{

    public function aisdata()
    {
        if (empty(request()->source)) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        $sensor = Sensor::find(1);

        $sensorData = new SensorData([
            'sensor_id' => $sensor->id,
            'payload' => request()->source,
            'timestamp' => Carbon::parse(request()->isoDate),
        ]);
        $sensorData->save();

        $vesselPosition = null;

        if (request()->mmsi) {
            $vessel = AisDataVessel::updateOrCreate(['mmsi' => request()->mmsi]);
            if ($vessel->wasRecentlyCreated) {
                // EventTracking::create([
                //     'event_id' => 6,
                //     'mmsi' => request()->mmsi,
                // ]);
            }

            $latitude = request()->latitude;
            $longitude = request()->longitude;
            if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
                $datalogger = Datalogger::find(1);
                $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
                $coordinate2 = new Coordinate(request()->latitude, request()->longitude);
                $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                $distanceInKilometers = $distance / 1000;
                $distanceInNauticalMiles = $distanceInKilometers * 0.539957;
                $vesselPosition = new AisDataPosition([
                    'sensor_data_id' => $sensorData->id,
                    'vessel_id' => $vessel->id,
                    'latitude' => request()->latitude,
                    'longitude' => request()->longitude,
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
            $vessel = AisDataVessel::updateOrCreate([
                'mmsi' => request()->senderMmsi,
            ], [
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
            ]);
            if ($vessel->wasRecentlyCreated) {
                // EventTracking::create([
                //     'event_id' => 6,
                //     'mmsi' => request()->mmsi,
                //     'ship_name' => request('name')
                // ]);
            }
        }

        $aisData = null;

        if ($vesselPosition) {
            $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
                ->orderBy('created_at', 'DESC')
                ->groupBy('vessel_id')
                ->where('id', $vesselPosition->id)
                ->first();
        }

        return response()->json([
            'aisData' => $aisData,
        ], 201);
    }
}
