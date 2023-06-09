<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $dataloggers = User::all();
        return response()->json($dataloggers);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
        $datalogger = User::create($data);
        return response()->json($datalogger, 201);
    }

    public function show(User $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($datalogger);
    }

    public function update(Request $request, User $datalogger)
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

    public function destroy(User $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $datalogger->delete();
        return response()->noContent();
    }
}
