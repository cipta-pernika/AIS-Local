<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Retrieve additional user details
            $userWithDetails = User::with('roles')->find($user->id);

            // Generate API token
            $token = $user->createToken('API Token')->plainTextToken;

            // Return response with token, user details, and roles
            return response()->json([
                'token' => $token,
                'user' => $userWithDetails,
                'roles' => $userWithDetails->roles // Assuming user has roles relation
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
