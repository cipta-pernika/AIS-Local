<?php

namespace App\Http\Controllers\Api;

use App\Models\Geofence;
use Illuminate\Http\Request;
use App\Http\Requests\GeofenceRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeofenceResource;

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
}
