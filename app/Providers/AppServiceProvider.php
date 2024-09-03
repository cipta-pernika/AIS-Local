<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Services\KeycloakProviderService;
use App\Providers\KeycloakProvider;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->singleton(KeycloakProviderService::class, function ($app) {
        //     return new KeycloakProviderService(
        //         $app['request'],
        //         $app['config']['services.keycloak']
        //     );
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Socialite $socialite): void
    {
        $socialite->extend('keycloak', function ($app) use ($socialite) {
            $config = $app['config']['services.keycloak'];
            return $socialite->buildProvider(KeycloakProvider::class, $config);
        });
        Model::unguard();
    }
}
