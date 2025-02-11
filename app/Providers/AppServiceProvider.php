<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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
        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Maps')
                    ->url(env('APP_ENV_URL') === 'local' ? 'http://localhost:3005' : 'https://sopbuntutksopbjm.com')
                    ->icon('heroicon-o-map'),
                // NavigationItem::make('Performance Monitoring')
                //     ->url('/pulse')
                //     ->icon('heroicon-o-trophy')
                //     ->group('Logs'),
                // NavigationItem::make('Klasifikasi Jenis Kapal')
                //     ->url('/admin/classifications')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Deteksi Anomali')
                //     ->url('/anomaly-detection')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Klasterisasi Pergerakan Kapal')
                //     ->url('/clustering')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Prediksi Posisi Kapal')
                //     ->url('/position-prediction')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Analisis Pola Waktu')
                //     ->url('/time-pattern-analysis')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Pendeteksian Geofence')
                //     ->url('/geofence-detection')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Klasifikasi Status Navigasi')
                //     ->url('/navigation-status')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
                // NavigationItem::make('Analisis Pelayaran Bersama (Convoy)')
                //     ->url('/convoy-analysis')
                //     ->icon('heroicon-o-trophy')
                //     ->group('AI'),
            ]);
        });
        FilamentAsset::register([
            Css::make('leaflet-1-9-4-css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css'),
            Js::make('leaflet-1-9-4-js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js'),
            AlpineComponent::make('aismaps-js', __DIR__ . '/../../resources/js/dist/aismaps.js'),
            AlpineComponent::make('playback-js', __DIR__ . '/../../resources/js/dist/playback.js')
        ]);
    }
}
