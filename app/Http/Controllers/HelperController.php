<?php

namespace App\Http\Controllers;

use App\Models\AisDataPort;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Models\Vessel;
use Carbon\Carbon;

class HelperController extends Controller
{
    function isValidLatitude($latitude)
    {
        return ($latitude >= -90 && $latitude <= 90);
    }

    function isValidLongitude($longitude)
    {
        return ($longitude >= -180 && $longitude <= 180);
    }

    public function aisdata()
    {
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
                    'status' => request()->navigationStatus,
                    'timestamp' => Carbon::parse(request()->isoDate),
                ]);
                $vesselPosition->save();
            }
        }

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
        ], 201);
    }
}
