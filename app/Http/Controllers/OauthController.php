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

        // If we don't have an authorization code then get one
        if (!isset($_GET['code'])) {

            // Fetch the authorization URL from the provider; this returns the
            // urlAuthorize option and generates and applies any necessary parameters
            // (e.g. state).
            $authorizationUrl = $provider->getAuthorizationUrl();

            // Get the state generated for you and store it to the session.
            $_SESSION['oauth2state'] = $provider->getState();

            // Optional, only required when PKCE is enabled.
            // Get the PKCE code generated for you and store it to the session.
            $_SESSION['oauth2pkceCode'] = $provider->getPkceCode();

            // Redirect the user to the authorization URL.
            return response()->json(['success' => true, 'message' => $authorizationUrl]);
        } elseif (empty($_GET['state']) || empty($_SESSION['oauth2state']) || $_GET['state'] !== $_SESSION['oauth2state']) {

            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }

            return response()->json(['error' => 'Invalid state'], 400);
        } else {

            try {

                // Optional, only required when PKCE is enabled.
                // Restore the PKCE code stored in the session.
                $provider->setPkceCode($_SESSION['oauth2pkceCode']);

                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);

                // We have an access token, which we may use in authenticated
                // requests against the service provider's API.
                $resourceOwner = $provider->getResourceOwner($accessToken);

                return response()->json([
                    'access_token' => $accessToken->getToken(),
                    'refresh_token' => $accessToken->getRefreshToken(),
                    'expires_in' => $accessToken->getExpires(),
                    'expired' => $accessToken->hasExpired(),
                    'resource_owner' => $resourceOwner->toArray()
                ]);
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // Failed to get the access token or user details.
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function handleCallback(Request $request)
    {
        // Handle the frontend callback logic here
        $data = $request->all();
        $data['handle_fe_get'] = true;
        $response = Http::post('https://nr.monitormyvessel.com/sso-test', $data);

        return redirect('https://sopbuntutksopbjm.com');
    }

    public function handleCallbackBackend(Request $request)
    {
        // Handle the backend callback logic here
        $data = $request->all();
        $data['handle_backend_post'] = true;
        $response = Http::post('https://nr.monitormyvessel.com/sso-test', $data);

        return response()->json(['message' => 'Backend callback received']);
    }

    public function handleCallbackBackendGet(Request $request)
    {
        // Handle the backend callback logic here
        $data = $request->all();
        $data['handle_backend_get'] = true;
        $response = Http::post('https://nr.monitormyvessel.com/sso-test', $data);

        session(['oauth_data' => $data]);

        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => env('CLIENT_ID_SSO'),
            'clientSecret'            => env('CLIENT_SECRET_SSO'),
            'redirectUri'             => 'https://backend.sopbuntutksopbjm.com/api/ssocallback/besopbuntut',
            'urlAuthorize'            => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth',
            'urlAccessToken'          => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/token',
            'urlResourceOwnerDetails' => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/userinfo'
        ]);

        // Save data into database
        \DB::table('oauth_sessions')->insert([
            'state' => $data['state'],
            'session_state' => $data['session_state'],
            'iss' => $data['iss'],
            'code' => $data['code'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        try {

            $PkceCode = $provider->getPkceCode();

            $provider->setPkceCode($PkceCode);

            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $data['code']
            ]);

            // dd($data['code']);

            $resourceOwner = $provider->getResourceOwner($accessToken);


            \DB::table('oauth_sessions')->updateOrInsert(
                ['state' => $data['state'], 'code' => $data['code']],
                [
                    'session_state' => $data['session_state'],
                    'iss' => $data['iss'],
                    'access_token' => $accessToken->getToken(),
                    'refresh_token' => $accessToken->getRefreshToken(),
                    'expires_in' => $accessToken->getExpires(),
                    'resource_owner' => json_encode($resourceOwner->toArray()),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        }

        return redirect('https://sopbuntutksopbjm.com/auth-pages/login?id=ZW1haWw6YWRtaW5AZGF0YWJhc2UuY29tLHBhc3N3b3JkOjEyMzQ1Ng==');
    }

    public function logout()
    {
        // Clear session data
        session()->forget('oauth_data');

        // Redirect to SSO logout URL
        $logoutUrl = 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?redirect_uri=https://sopbuntutksopbjm.com';

        return redirect($logoutUrl);
    }

    public function loginviasso()
    {
        return response()->json(['msg' => Socialite::driver('keycloak')->redirect()]);

        // return redirect('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth?client_id=sop-buntut-api&response_type=code&scope=openid&redirect_uri=https://sopbuntutksopbjm.com/ssocallback/fesopbuntut');
    }

    public function ssosession()
    {
        return response()->json(['msg' => session('oauth_data')]);
    }
}
