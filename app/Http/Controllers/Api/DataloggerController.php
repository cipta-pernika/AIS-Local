<?php

namespace App\Http\Controllers\Api;

use App\Models\Datalogger;
use Illuminate\Http\Request;
use App\Http\Requests\DataloggerRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataloggerResource;

class DataloggerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataloggers = Datalogger::paginate();

        return DataloggerResource::collection($dataloggers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataloggerRequest $request): Datalogger
    {
        return Datalogger::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Datalogger $datalogger): Datalogger
    {
        return $datalogger;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DataloggerRequest $request, Datalogger $datalogger): Datalogger
    {
        $datalogger->update($request->validated());

        return $datalogger;
    }

    public function destroy(Datalogger $datalogger): Response
    {
        $datalogger->delete();

        return response()->noContent();
    }
}
