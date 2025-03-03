<?php

namespace App\Http\Controllers;

use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Datalogger;
use Location\Coordinate;
use Location\Distance\Haversine;
use Illuminate\Support\Facades\Cache;

class RadarDataSpxController extends Controller
{
    public function radardataspx(Request $request)
    {
        $data = $request->json()->all();
        
        // Create cache key based on request data hash
        $cacheKey = 'radar_spx_' . md5(json_encode($data));
        
        // Process only if data not in cache (cache for 5 seconds to prevent duplicate processing)
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, 5);
            
            // Get datalogger position once
            $datalogger = Datalogger::find(1);
            $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
            
            // Prepare batch updates
            $updates = [];
            $radarPosition = null;
            
            foreach ($data['features'] as $feature) {
                $properties = $feature->properties;
                $geometry = $feature->geometry->coordinates;
                
                $coordinate2 = new Coordinate($geometry[1], $geometry[0]);
                $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                $distanceInNauticalMiles = ($distance / 1000) * 0.539957;
                
                $updates[] = [
                    'target_id' => $properties->name,
                    'latitude' => $geometry[1],
                    'longitude' => $geometry[0],
                    'altitude' => $properties->altitude,
                    'speed' => $properties->speed,
                    'course' => $properties->course,
                    'heading' => $properties->heading,
                    'range' => $properties->range,
                    'bearing' => $properties->bearing,
                    'timestamp' => Carbon::now(),
                    'distance_from_fak' => $distanceInNauticalMiles
                ];
                
                // Store radar position for datalogger update
                if ($properties->type === 'Radar') {
                    $radarPosition = [
                        'latitude' => $geometry[1],
                        'longitude' => $geometry[0]
                    ];
                }
            }
            
            // Batch update radar data
            foreach ($updates as $update) {
                RadarData::updateOrCreate(
                    ['target_id' => $update['target_id']],
                    $update
                );
            }
            
            // Update datalogger position if radar data exists
            if ($radarPosition) {
                $datalogger->update($radarPosition);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data processed successfully'
        ], 200);
    }
}
