<?php

namespace App\Http\Controllers\Api;

use App\Models\AisDataPosition;
use Illuminate\Http\Request;
use App\Http\Requests\AisDataPositionRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AisDataPositionResource;
use Illuminate\Support\Facades\Cache;
use App\Models\EventTracking;

class AisDataPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $vessels = request()->vessels;
        // $vessel_name = request()->vessel_name;
        // $mmsi = request()->mmsi;
        // $limit = request()->limit;
        // $page = request()->page;
        // $order = request()->order;

        // $query = AisDataPosition::with('aisDataVessel');

        // if (!empty($vessels)) {
        //     $query->whereIn('vessel_id', $vessels);
        // }

        // if ($vessel_name) {
        //     $query->whereHas('aisDataVessel', function ($q) use ($vessel_name) {
        //         $q->where('vessel_name', $vessel_name);
        //     });
        // }

        // if ($mmsi) {
        //     $query->whereHas('aisDataVessel', function ($q) use ($mmsi) {
        //         $q->where('mmsi', $mmsi);
        //     });
        // }

        // if ($order) {
        //     $query->orderBy('timestamp', $order);
        // }

        // $aisDataPositions = $query->paginate($limit, ['*'], 'page', $page);

        // return AisDataPositionResource::collection($aisDataPositions);
        // Define a unique cache key for this query
        // $cacheKey = 'event_trackings_cache';

        // // Check if the result is already in the cache
        // if (Cache::has($cacheKey)) {
        //     // If cached, return the cached result
        //     $event = Cache::get($cacheKey);
        // } else {
            // If not cached, perform the query and store the result in the cache
            $event = EventTracking::where('event_id', 9)
                ->orderBy('created_at', 'DESC')
                ->with([
                    'aisDataPosition',
                    'aisDataPosition.vessel',
                    'geofence',
                    'event',
                    'aisDataPosition.reportGeofences' => function ($query) {
                        $query->whereNotNull('in'); // Only include records where 'in' is not null
                    }, 
                    'aisDataPosition.reportGeofences.geofenceImages'
                ])
                ->whereNotNull('mmsi')
                ->whereNotNull('ais_data_position_id')
                // ->whereHas('aisDataPosition.reportGeofences') // Only include records that have related reportGeofences
                ->whereHas('aisDataPosition.reportGeofences', function ($query) {
                    $query->whereNotNull('in');
                }) // Only include records that have related reportGeofences
                ->limit(50)
                ->get();

            // Cache the result for 60 minutes (you can adjust the duration)
            // Cache::put($cacheKey, $event, 60);
        // }

        return response()->json([
            'success' => true,
            'data' => $event,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AisDataPositionRequest $request): AisDataPosition
    {
        return AisDataPosition::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AisDataPosition $aisDataPosition): AisDataPosition
    {
        return $aisDataPosition;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AisDataPositionRequest $request, AisDataPosition $aisDataPosition): AisDataPosition
    {
        $aisDataPosition->update($request->validated());

        return $aisDataPosition;
    }

    public function destroy(AisDataPosition $aisDataPosition): Response
    {
        $aisDataPosition->delete();

        return response()->noContent();
    }
}
