<?php

namespace App\Http\Controllers\Api;

use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Http\Requests\SensorRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SensorResource;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sensors = Sensor::paginate();

        return SensorResource::collection($sensors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SensorRequest $request): Sensor
    {
        return Sensor::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor): Sensor
    {
        return $sensor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SensorRequest $request, Sensor $sensor): Sensor
    {
        $sensor->update($request->validated());

        return $sensor;
    }

    public function destroy(Sensor $sensor): Response
    {
        $sensor->delete();

        return response()->noContent();
    }
}
