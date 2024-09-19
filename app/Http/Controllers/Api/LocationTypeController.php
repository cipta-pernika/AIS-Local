<?php

namespace App\Http\Controllers\Api;

use App\Models\LocationType;
use Illuminate\Http\Request;
use App\Http\Requests\LocationTypeRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationTypeResource;

class LocationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locationTypes = LocationType::paginate();

        return LocationTypeResource::collection($locationTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationTypeRequest $request): LocationType
    {
        return LocationType::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(LocationType $locationType): LocationType
    {
        return $locationType;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationTypeRequest $request, LocationType $locationType): LocationType
    {
        $locationType->update($request->validated());

        return $locationType;
    }

    public function destroy(LocationType $locationType): Response
    {
        $locationType->delete();

        return response()->noContent();
    }
}
