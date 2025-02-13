<?php

namespace App\Http\Controllers\Api;

use App\Models\Geofence;
use Illuminate\Http\Request;
use App\Http\Requests\GeofenceRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeofenceResource;
use Illuminate\Support\Facades\Cache;
class GeofenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $geofences = Geofence::paginate();

        return GeofenceResource::collection($geofences);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GeofenceRequest $request): Geofence
    {
        return Geofence::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Geofence $geofence): Geofence
    {
        return $geofence;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GeofenceRequest $request, Geofence $geofence): Geofence
    {
        $geofence->update($request->validated());

        return $geofence;
    }

    public function destroy(Geofence $geofence): Response
    {
        $geofence->delete();

        return response()->noContent();
    }

    public function getgeofence()
    {

        // Create a descriptive cache key
        $cacheKey = 'all_geofences';

        // Attempt to retrieve data from the cache
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            // If not cached, fetch the data from the database
            $geo = Geofence::where('isMaster', 0)->where('isHidden', 0)->get();

            // Store the retrieved data in the cache
            Cache::put($cacheKey, $geo, 60); // Cache for 60 minutes
        } else {
            // Data is already cached
            $geo = $cachedData;
        }

        return response()->json([
            'success' => true,
            'message' => $geo,
        ], 200);
    }

    public function setgeofence()
    {
        $geo = new Geofence();
        $geo->user_id = request('userId');
        $geo->geofence_name = request('name');
        $geo->type = request('typegeo');
        $geo->type_geo = request('typeShape');
        $geo->radius = request('radius');
        $geo->pelabuhan_id = request('pelabuhan_id');
        $geo->geofence_type_id = request('typeGeofence');
        $geo->geometry = json_encode(request('geoDraw'));
        $geo->save();

        foreach (request('assetgeo') as $asset) {
            $geobinding = new GeofenceBinding;
            $geobinding->geofence_id = $geo->id;
            $geobinding->asset_id = $asset;
            $geobinding->save();
        }

        $geod = Geofence::where('id', $geo->id)
            ->with('pelabuhan')
            ->first();

        Cache::forget('all_geofences');

        return response()->json([
            'success' => true,
            'message' => $geod,
        ], 200);
    }
}
