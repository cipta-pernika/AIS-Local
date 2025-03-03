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
        
        // Validate required data structure
        if (!isset($data['features']) || !is_array($data['features'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data format: features array is required'
            ], 400);
        }
        
        // Create cache key based on request data hash
        $cacheKey = 'radar_spx_' . md5(json_encode($data));
        
        // Process only if data not in cache (cache for 5 seconds to prevent duplicate processing)
        if (!Cache::has($cacheKey)) {
            try {
                Cache::put($cacheKey, true, 5);
                
                // Get datalogger position once
                $datalogger = Datalogger::find(1);
                $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
                
                // Prepare batch updates
                $updates = [];
                $radarPosition = null;
                
                foreach ($data['features'] as $feature) {
                    // Validate feature structure
                    if (!isset($feature['properties']) || !isset($feature['geometry']['coordinates'])) {
                        continue; // Skip invalid features
                    }
                    
                    // Convert feature data to object for consistent access
                    $properties = (object)$feature['properties'];
                    $geometry = (object)$feature['geometry'];
                    $coordinates = $geometry->coordinates;
                    
                    // Skip invalid coordinates (0,0)
                    if ($coordinates[0] == 0 && $coordinates[1] == 0) {
                        continue;
                    }
                    
                    $coordinate2 = new Coordinate($coordinates[1], $coordinates[0]);
                    $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                    $distanceInNauticalMiles = ($distance / 1000) * 0.539957;
                    
                    $updates[] = [
                        'target_id' => $properties->name,
                        'latitude' => $coordinates[1],
                        'longitude' => $coordinates[0],
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
                            'latitude' => $coordinates[1],
                            'longitude' => $coordinates[0]
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
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data processed successfully'
                ], 200);
                
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error processing data: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data already processed'
        ], 200);
    }
}
