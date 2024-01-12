<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function getlocationtype()
    {
        $loctype = LocationType::all();

        return response()->json([
            'success' => true,
            'message' => $loctype,
        ], 200);
    }

    public function setlocation()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'typeloc' => 'required|exists:location_types,id', // Validate that the location_type_id exists in the location_types table
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        // Create a new Location model instance
        $location = new Location([
            'name' => $data['name'],
            'latitude' => $data['lat'],
            'longitude' => $data['long'],
        ]);

        // Save the location record and associate it with the specified location type
        $locationType = LocationType::find($data['typeloc']);
        $locationType->locations()->save($location);

        // Fetch the complete Location record including the LocationType information
        $location = Location::with('locationType') // Eager load the location type relationship
            ->select(
                'id',
                'name',
                'latitude',
                'longitude',
                'created_at',
                'updated_at',
                'location_type_id'
            )
            ->where('id', $location->id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => $location,
        ], 200);
    }

    public function getlocation()
    {
        // Define a unique cache key for this query
        $cacheKey = 'locations_cache';

        // Check if the result is already in the cache
        if (Cache::has($cacheKey)) {
            // If cached, return the cached result
            $locations = Cache::get($cacheKey);
        } else {
            // If not cached, perform the query and store the result in the cache
            $locations = Location::with('locationType')
                ->select('id', 'name', 'latitude', 'longitude', 'location_type_id')
                ->get();

            // Cache the result for 24 hours (adjust the duration as needed)
            Cache::put($cacheKey, $locations, 60);
        }

        return response()->json([
            'success' => true,
            'message' => $locations,
        ], 200);
    }

    public function deletelocation()
    {
        $loc = Location::find(request('idLoc'));
        $loc->delete();

        return response()->json([
            'success' => true,
            'message' => $loc,
        ], 200);
    }
}
