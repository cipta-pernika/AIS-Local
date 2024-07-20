<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return response()->json(['success' => true, 'message' => $authorizationUrl . '&scope=openid%20profile%20email%20offline_access']);
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
        \DB::table('oauth_sessions')->updateOrInsert(
            ['session_state' => $data['session_state']],
            [
                'state' => $data['state'],
                'iss' => $data['iss'],
                'code' => $data['code'],
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        try {

            $PkceCode = $provider->getPkceCode();

            $provider->setPkceCode($PkceCode);

            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $data['code']
            ]);

            // dd($data['code']);
            try {
                $resourceOwner = $provider->getResourceOwner($accessToken);
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                $resourceOwner = '[]';
            }


            \DB::table('oauth_sessions')->updateOrInsert(
                ['session_state' => $data['session_state']],
                [
                    'state' => $data['state'],
                    'code' => $data['code'],
                    'session_state' => $data['session_state'],
                    'iss' => $data['iss'],
                    'access_token' => $accessToken->getToken(),
                    'refresh_token' => $accessToken->getRefreshToken(),
                    'id_token' => $accessToken->getValues()['id_token'] ?? null,
                    'expires_in' => $accessToken->getExpires(),
                    'resource_owner' => json_encode($resourceOwner->toArray()),
                    // 'resource_owner' => '[]',
                    'updated_at' => now()
                ]
            );
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        }

        return redirect('https://sopbuntutksopbjm.com/auth-pages/login?id=ZW1haWw6YWRtaW5AZGF0YWJhc2UuY29tLHBhc3N3b3JkOjEyMzQ1Ng==');
    }

    public function logout()
    {
        $oauthData = session('oauth_data');

        if ($oauthData) {
            $sessionState = $oauthData['session_state'];
        } else {
            $sessionState = \DB::table('oauth_sessions')->orderBy('id', 'desc')->first()->session_state;
        }
        // Clear session data
        session()->forget('oauth_data');

        $idToken = \DB::table('oauth_sessions')->where('session_state', $sessionState)->first()->id_token;
        $logoutSSo = Http::get('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?id_token_hint=' . $idToken);
        // Redirect to SSO logout URL
        // if($logoutSSo->getStatusCode() == 200){
        //     $logoutUrl = 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?redirect_url=https://sopbuntutksopbjm.com';
        // }else{
        //     $logoutUrl = 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?redirect_url=https://sopbuntutksopbjm.com';
        // }

        return response()->json(['message' => 'Logout successful']);
    }

    public function logoutsso()
    {
        // Clear session data
        $oauthData = session('oauth_data');

        if ($oauthData) {
            $sessionState = $oauthData['session_state'];
        } else {
            $sessionState = \DB::table('oauth_sessions')->orderBy('id', 'desc')->first()->session_state;
        }

        session()->forget('oauth_data');

        $idToken = \DB::table('oauth_sessions')->where('session_state', $sessionState)->first()->id_token;
        $logoutSSo = Http::get('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?id_token_hint=' . $idToken);
        // Redirect to SSO logout URL
        // if($logoutSSo->getStatusCode() == 200){
        //     $logoutUrl = 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?redirect_url=https://sopbuntutksopbjm.com';
        // }else{
        //     $logoutUrl = 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/logout?redirect_url=https://sopbuntutksopbjm.com';
        // }

        return response()->json(['message' => 'Logout successful']);
    }

    public function loginviasso()
    {
        // return response()->json(['msg' => Socialite::driver('keycloak')->redirect()]);
        return Socialite::driver('keycloak')->scopes(['openid','profile','email','offline_access'])->redirect();
        // return redirect('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth?client_id=sop-buntut-api&response_type=code&scope=openid&redirect_uri=https://sopbuntutksopbjm.com/ssocallback/fesopbuntut');
    }

    public function loginviasso2()
    {
        // return response()->json(['msg' => Socialite::driver('keycloak')->redirect()]);
        return  response()->json(['success'=>true,'message' => str_replace('client_id=sop-buntut-api&','',Socialite::driver('keycloak')->scopes(['openid','profile','email','offline_access'])->redirect()->getTargetUrl())]);
        // return redirect('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth?client_id=sop-buntut-api&response_type=code&scope=openid&redirect_uri=https://sopbuntutksopbjm.com/ssocallback/fesopbuntut');
    }

    public function ssocallbackhandler(Request $request){
        if(!$request->has('error')){
            $user = Socialite::driver('keycloak')->user();

            // dd($user);
            session(['oauth_data' => $user]);
    
            $tokenResponse = $user->accessTokenResponseBody;
    
            \DB::table('oauth_sessions')->updateOrInsert(
                    ['session_state' => $tokenResponse['session_state']],
                    [
                        'state' => $request->get('state'),
                        'code' => $request->get('code'),
                        'session_state' => $tokenResponse['session_state'],
                        'iss' => $request->get('iss'),
                        'access_token' => $tokenResponse['access_token'],
                        'refresh_token' => $tokenResponse['refresh_token'],
                        'id_token' => $tokenResponse['id_token'] ?? null,
                        'expires_in' => $tokenResponse['expires_in'],
                        'resource_owner' => json_encode($user->user),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
            );
    
            return redirect('https://sopbuntutksopbjm.com/auth-pages/login?id=ZW1haWw6YWRtaW5AZGF0YWJhc2UuY29tLHBhc3N3b3JkOjEyMzQ1Ng==');
        }else{
            $oauthData = session('oauth_data');
            if($oauthData){
                \DB::table('oauth_sessions')->update(
                    ['session_state'=>$oauthData->accessTokenResponseBody['session_state']],
                    [
                        'is_login'=>0,
                        'updated_at'=>now()
                    ]
                );
            }
            
            return redirect('https://sopbuntutksopbjm.com');
        }

    }

    public function checkSSO(){
        $oauthData = session('oauth_data');
        // dd($oauthData);
        if(!$oauthData){
            return response()->json(['message'=>'unauthorized'],401);
        }
        
        $sessionState = $oauthData->accessTokenResponseBody['session_state'];
        $code = \DB::table('oauth_sessions')->where('session_state',$sessionState)->first()->code;
        $url = Socialite::driver('keycloak')->scopes(['openid','profile','email','offline_access'])->redirect()->getTargetUrl()."&code=".$code."&prompt=none";


        // $accessToken = $oauthData->token;

        // $response = Http::withHeaders(['Accept'=>'application/json'])->asForm()->post(env('KEYCLOAK_BASE_URL') . '/realms/' . env('KEYCLOAK_REALM') . '/protocol/openid-connect/token/introspect', [
        //     'token' => $accessToken,
        //     'client_id' => env('KEYCLOAK_CLIENT_ID'),
        //     'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
        // ]);

        // $introspection = $response->json();
        
        
        // if (isset($introspection['active']) && $introspection['active']) {
        //     return response()->json(['message' => 'Token is valid', 'data' => $introspection], 200);
        // } else {
        //     return response()->json(['message' => 'Token is invalid or expired'], 401);
        // }
        
        // return (response()->json( $this->getFinalUrl($url)));

        return redirect($url);
    }
    
    public function getFinalUrl($url)
    {
        $client = new \GuzzleHttp\Client(['allow_redirects' => ['track_redirects' => true]]);
        $redirs = [];
        
        $response = $client->get($url,[
            'on_stats'=>function (\GuzzleHttp\TransferStats $stats) use (&$redirs){
        		array_push($redirs, $stats->getEffectiveUri());
        	},
        ]);
        return $redirs;
    }


    public function ssosession()
    {
        $oauthData = session('oauth_data');
        if ($oauthData) {
            return response()->json(['msg' => $oauthData]);
        } else {
            return response()->json(['error' => 'No session data found'], 400);
        }
    }

    public function renewToken()
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => env('CLIENT_ID_SSO'),
            'clientSecret'            => env('CLIENT_SECRET_SSO'),
            'redirectUri'             => 'https://backend.sopbuntutksopbjm.com/api/ssocallback/besopbuntut',
            'urlAuthorize'            => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/auth',
            'urlAccessToken'          => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/token',
            'urlResourceOwnerDetails' => 'https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/userinfo'
        ]);

        $oauthData = session('oauth_data');

        if ($oauthData) {
            $sessionState = $oauthData['session_state'];
        } else {
            $sessionState = \DB::table('oauth_sessions')->orderBy('id', 'desc')->first()->session_state;
        }

        $accessToken = $provider->getAccessToken('refresh_token', [
            'refresh_token' => \DB::table('oauth_sessions')->where('session_state', $sessionState)->first()->refresh_token
        ]);

        return response()->json(['access_token' => $accessToken->getToken()]);
    }

    public function checkIsTokenValid()
    {
        $oauthData = session('oauth_data');

        if ($oauthData) {
            // $sessionState = $oauthData['session_state'];
            $sessionState = $oauthData->accessTokenResponseBody['session_state'];
        } else {
            $sessionState = \DB::table('oauth_sessions')->orderBy('id', 'desc')->first()->session_state;
        }
        $oauthFromDB = \DB::table('oauth_sessions')->where('session_state', $sessionState)->first();
        $accessToken = $oauthFromDB->access_token;
        
        // $code = $oauthData->code;
        // $authUrl = Socialite::driver('keycloak')->scopes(['openid','profile','email','offline_access'])->redirect()->getTargetUrl()."&code=".$code."&prompt=none";
        
        // $finalUrl = $this->getFinalUrl($authUrl);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->get('https://sso-dev.hubla.dephub.go.id/realms/djpl/protocol/openid-connect/userinfo');

        if (!$response->json()) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        // Check Sanctum token
        // if (!Auth::guard('sanctum')->check()) {
        //     return response()->json(['message' => 'Sanctum token invalid'], 401);
        // }

        return response()->json(['message' => 'Token is valid', 'data' => $response->json()], 200);
    }
}
