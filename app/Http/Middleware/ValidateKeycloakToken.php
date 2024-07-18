<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class ValidateKeycloakToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Session::get('keycloak_user.token');

        if (!$token || !$this->isTokenValid($token)) {
            return redirect('/logout');
        }

        return $next($request);
    }

    private function isTokenValid($token)
    {
        try {
            $user = Socialite::driver('keycloak')->userFromToken($token);
            return !empty($user);
        } catch (\Exception $e) {
            return false;
        }
    }
}
