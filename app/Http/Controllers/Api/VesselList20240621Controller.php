<?php

namespace App\Http\Controllers\Api;

use App\Models\VesselList20240621;
use Illuminate\Http\Request;
use App\Http\Requests\VesselList20240621Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VesselList20240621Resource;

class VesselList20240621Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vesselList20240621s = VesselList20240621::paginate();

        return VesselList20240621Resource::collection($vesselList20240621s);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VesselList20240621Request $request): VesselList20240621
    {
        return VesselList20240621::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(VesselList20240621 $vesselList20240621): VesselList20240621
    {
        return $vesselList20240621;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VesselList20240621Request $request, VesselList20240621 $vesselList20240621): VesselList20240621
    {
        $vesselList20240621->update($request->validated());

        return $vesselList20240621;
    }

    public function destroy(VesselList20240621 $vesselList20240621): Response
    {
        $vesselList20240621->delete();

        return response()->noContent();
    }
}
