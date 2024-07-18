<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{
    public function authorization()
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => env('CLIENT_ID_SSO'),    // The client ID assigned to you by the provider
            'clientSecret'            => env('CLIENT_SECRET_SSO'),    // The client password assigned to you by the provider
            'redirectUri'             => 'https://backend.sopbuntutksopbjm.com/api/ssocallback/besopbuntut',
            'urlAuthorize'            => 'https://sso.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth',
            'urlAccessToken'          => 'https://sso.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/token',
            'urlResourceOwnerDetails' => 'https://sso.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/userinfo'
        ]);

        $authorizationUrl = $provider->getAuthorizationUrl();

        return redirect($authorizationUrl);

        // https://sso.hubla.dephub.go.id/
        // realms/djpl/protocol/openid-connect/
        // auth?state=b41bd5628a2e3895bad456b9c0945a3e
        // &response_type=code&approval_prompt=auto&
        // redirect_uri=https%3A%2F%2Fbackend.sopbuntutksopbjm.com%2Fapi%2Fssocallback%2Fbesopbuntut&client_id=sop-buntut-api

        // https://sso.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/
        // auth?state=77ad08c0282e54ec7bc7683695ca94f9&response_type=code&approval_prompt=
        // auto&redirect_uri=https%3A%2F%2Fbackend.sopbuntutksopbjm.com%2Fapi%2Fssocallback%2Fbesopbuntut&client_id=sop-buntut-api

        // {
        //     "id": "8e1c905aa5724c71a3724ae6bd908c67",
        //     "created": 1721298078,
        //     "request_type": "si:r",
        //     "code_verifier": "be08becacb604eef8b1f31cbef861a8a0984b42607974d8a9588377f5db9d24f651939dfb33240b3b0cc7f9e62bc8a16",
        //     "authority": "https://sso-dev.hubla.dephub.go.id/realms/djpl",
        //     "client_id": "sop-buntut-api",
        //     "redirect_uri": "https://backend.sopbuntutksopbjm.com/api/ssocallback/besopbuntut",
        //     "scope": "openid email profile",
        //     "client_secret": "rMBqlBpl3hjDljsjmO2qjE308CTXJdT5",
        //     "extraTokenParams": {}
        //   }
    }

    public function handleCallback()
    {
        // Handle the frontend callback logic here
        // Example: return response or process data
        return redirect('https://sopbuntutksopbjm.com');
    }

    public function handleCallbackBackend()
    {
        // Handle the backend callback logic here
        // Example: return response or process data
        return response()->json(['message' => 'Backend callback received']);
    }

    public function handleCallbackBackendGet()
    {
        // Handle the backend callback logic here
        // Example: return response or process data
        return redirect('https://sopbuntutksopbjm.com');
    }

    public function loginviasso()
    {
        return response()->json(['msg' => Socialite::driver('keycloak')->redirect()]);

        // return redirect('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth?client_id=sop-buntut-api&response_type=code&scope=openid&redirect_uri=https://sopbuntutksopbjm.com/ssocallback/fesopbuntut');
    }
}
