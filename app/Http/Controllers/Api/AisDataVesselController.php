<?php

namespace App\Http\Controllers\Api;

use App\Models\AisDataVessel;
use Illuminate\Http\Request;
use App\Http\Requests\AisDataVesselRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AisDataVesselResource;

class AisDataVesselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $aisDataVessels = AisDataVessel::paginate();

        return AisDataVesselResource::collection($aisDataVessels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AisDataVesselRequest $request): AisDataVessel
    {
        return AisDataVessel::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AisDataVessel $aisDataVessel): AisDataVessel
    {
        return $aisDataVessel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AisDataVesselRequest $request, AisDataVessel $aisDataVessel): AisDataVessel
    {
        $aisDataVessel->update($request->validated());

        return $aisDataVessel;
    }

    public function destroy(AisDataVessel $aisDataVessel): Response
    {
        $aisDataVessel->delete();

        return response()->noContent();
    }
}
