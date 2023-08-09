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

    public function show($id)
    {
        $datalogger = User::find($id);

        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($datalogger);
    }

    public function update(Request $request, User $user)
    {
        if (!$user) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => [
                'string',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'string',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'status' => 'string',
            'installation_date' => 'date',
            'last_online' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $userData = $request->all();
    
        // Hash the password if it's provided in the request
        if (isset($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        }
    
        $user->update($userData);
        
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function destroy(User $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $datalogger->delete();
        return response()->json(['message' => 'Data deleted successfully']);
    }
}
