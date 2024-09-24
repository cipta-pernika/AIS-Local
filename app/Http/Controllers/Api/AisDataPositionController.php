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
        $aisDataPositions = AisDataPosition::paginate();

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
