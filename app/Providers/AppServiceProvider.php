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

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Maps')
                    ->url('https://coastal.cakrawala.id')
                    ->icon('heroicon-o-map'),
            ]);
        });
        FilamentAsset::register([
            Css::make('leaflet-1-9-4-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'),
            Js::make('leaflet-1-9-4-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'),
            AlpineComponent::make('aismaps-js', __DIR__ . '/../../resources/js/dist/aismaps.js')      
        ]);
    }
}
