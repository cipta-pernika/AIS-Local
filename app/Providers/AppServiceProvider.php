<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
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
                    ->icon('heroicon-o-map')
                    ->sort(0),
            ]);
        });
    }
}
