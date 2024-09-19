<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locations = Location::paginate();

        return LocationResource::collection($locations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request): Location
    {
        return Location::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location): Location
    {
        return $location;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request, Location $location): Location
    {
        $location->update($request->validated());

        return $location;
    }

    public function destroy(Location $location): Response
    {
        $location->delete();

        return response()->noContent();
    }
}
