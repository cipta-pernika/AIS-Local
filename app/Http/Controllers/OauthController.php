<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{
    public function authorization()
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => env('CLIENT_ID_SSO'),    // The client ID assigned to you by the provider
            'clientSecret'            => env('CLIENT_SECRET_SSO'),    // The client password assigned to you by the provider
            'redirectUri'             => 'https://backend.sopbuntutksopbjm.com/api/ssocallback/besopbuntut',
            'urlAuthorize'            => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth',
            'urlAccessToken'          => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/token',
            'urlResourceOwnerDetails' => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/userinfo'
        ]);

        $authorizationUrl = $provider->getAuthorizationUrl();

        return response()->json([
            'success' => true,
            'message' => $authorizationUrl
        ]);
    }

    public function handleCallback(Request $request)
    {
        // Handle the frontend callback logic here
        $data = $request->all();
        $response = Http::post('https://nr.monitormyvessel.com/sso-test', $data);

        return redirect('https://sopbuntutksopbjm.com');
    }

    public function handleCallbackBackend(Request $request)
    {
        // Handle the backend callback logic here
        $data = $request->all();
        $response = Http::post('https://nr.monitormyvessel.com/sso-test', $data);

        return response()->json(['message' => 'Backend callback received']);
    }

    public function handleCallbackBackendGet(Request $request)
    {
        // Handle the backend callback logic here
        $data = $request->all();
        $response = Http::post('https://nr.monitormyvessel.com/sso-test', $data);

        return redirect('https://sopbuntutksopbjm.com');
    }

    public function loginviasso()
    {
        return response()->json(['msg' => Socialite::driver('keycloak')->redirect()]);

        // return redirect('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth?client_id=sop-buntut-api&response_type=code&scope=openid&redirect_uri=https://sopbuntutksopbjm.com/ssocallback/fesopbuntut');
    }
}
