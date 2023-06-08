<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SensorController extends Controller
{
    public function index()
    {
        $dataloggers = Sensor::all();
        return response()->json($dataloggers);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'datalogger_id' => 'required|exists:dataloggers,id',
            'status' => 'required|string',
            'interval' => 'required|integer',
            'jarak' => 'required|integer',
            'jumlah_data' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $datalogger = Sensor::create($request->all());
        return response()->json($datalogger, 201);
    }

    public function show(Sensor $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($datalogger);
    }

    public function update(Request $request, Sensor $datalogger)
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

    public function destroy(Sensor $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $datalogger->delete();
        return response()->noContent();
    }
}
