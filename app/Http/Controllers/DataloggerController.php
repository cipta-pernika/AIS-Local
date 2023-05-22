<?php

namespace App\Http\Controllers;

use App\Models\Datalogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DataloggerController extends Controller
{
    public function index()
    {
        $dataloggers = Datalogger::all();
        return response()->json($dataloggers);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'serial_number' => 'required|string|unique:dataloggers',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|string',
            'installation_date' => 'required|date',
            'last_online' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $datalogger = Datalogger::create($request->all());
        return response()->json($datalogger, 201);
    }

    public function show(Datalogger $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($datalogger);
    }

    public function update(Request $request, Datalogger $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'serial_number' => [
                'string',
                Rule::unique('dataloggers')->ignore($datalogger->id),
            ],
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'status' => 'string',
            'installation_date' => 'date',
            'last_online' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $datalogger->update($request->all());
        return response()->json($datalogger);
    }

    public function destroy(Datalogger $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $datalogger->delete();
        return response()->noContent();
    }
}
