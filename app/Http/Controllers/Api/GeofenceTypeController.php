<?php

namespace App\Http\Controllers\Api;

use App\Models\GeofenceType;
use Illuminate\Http\Request;
use App\Http\Requests\GeofenceTypeRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeofenceTypeResource;

class GeofenceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $geofenceTypes = GeofenceType::paginate();

        return GeofenceTypeResource::collection($geofenceTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GeofenceTypeRequest $request): GeofenceType
    {
        return GeofenceType::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(GeofenceType $geofenceType): GeofenceType
    {
        return $geofenceType;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GeofenceTypeRequest $request, GeofenceType $geofenceType): GeofenceType
    {
        $geofenceType->update($request->validated());

        return $geofenceType;
    }

    public function destroy(GeofenceType $geofenceType): Response
    {
        $geofenceType->delete();

        return response()->noContent();
    }
}
