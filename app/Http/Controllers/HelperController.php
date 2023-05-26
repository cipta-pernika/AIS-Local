<?php

namespace App\Http\Controllers;

use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\Sensor;
use App\Models\SensorData;
use Carbon\Carbon;

class HelperController extends Controller
{
    public function isValidLatitude($latitude)
    {
        return ($latitude >= -90 && $latitude <= 90);
    }

    public function isValidLongitude($longitude)
    {
        return ($longitude >= -180 && $longitude <= 180);
    }

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

        if (request()->mmsi) {
            $vessel = AisDataVessel::updateOrCreate(['mmsi' => request()->mmsi]);

            $latitude = request()->latitude;
            $longitude = request()->longitude;
            if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
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
                ]);
                $vesselPosition->save();
            }
        } else if (request()->senderMmsi) {
            $vessel = AisDataVessel::updateOrCreate([
                'mmsi' => request()->senderMmsi
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
            ]);
        }

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
            'vessel' => $vessel ?? null,
            'vesselPosition' => $vesselPosition ?? null
        ], 201);
    }

    public function getaisdata()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function aisdataunique()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->groupBy('vessel_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }
}
