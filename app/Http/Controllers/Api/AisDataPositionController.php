<?php

namespace App\Http\Controllers\Api;

use App\Models\AisDataPosition;
use Illuminate\Http\Request;
use App\Http\Requests\AisDataPositionRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AisDataPositionResource;

class AisDataPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vessels = request()->vessels;
        $vessel_name = request()->vessel_name;
        $mmsi = request()->mmsi;
        $limit = request()->limit;
        $page = request()->page;
        $order = request()->order;

        $query = AisDataPosition::with('aisDataVessel');

        if (!empty($vessels)) {
            $query->whereIn('vessel_id', $vessels);
        }

        if ($vessel_name) {
            $query->whereHas('aisDataVessel', function ($q) use ($vessel_name) {
                $q->where('vessel_name', $vessel_name);
            });
        }

        if ($mmsi) {
            $query->whereHas('aisDataVessel', function ($q) use ($mmsi) {
                $q->where('mmsi', $mmsi);
            });
        }

        if ($order) {
            $query->orderBy('timestamp', $order);
        }

        $aisDataPositions = $query->paginate($limit, ['*'], 'page', $page);

        return AisDataPositionResource::collection($aisDataPositions);
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
