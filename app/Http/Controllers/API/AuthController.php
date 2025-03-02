<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            // Safe handling of relationships (roles and permissions)
            $roles = method_exists($user, 'roles') ? $user->roles : [];
            $permissions = method_exists($user, 'permissions') ? $user->permissions : [];

            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'two_factor_secret' => $user->two_factor_secret,
                    'two_factor_recovery_codes' => $user->two_factor_recovery_codes,
                    'two_factor_confirmed_at' => $user->two_factor_confirmed_at,
                    'sound_notif' => $user->sound_notif ?? false,
                    'sound_alarm' => $user->sound_alarm ?? false,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'roles' => $roles,
                    'permissions' => $permissions,
                ]
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
