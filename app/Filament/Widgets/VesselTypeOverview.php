<?php

namespace App\Filament\Widgets;

use App\Models\AisDataVessel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VesselTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Fishing', AisDataVessel::query()->where('vessel_type', 'Fishing')->count()),
            Stat::make('Tug', AisDataVessel::query()->where('vessel_type', 'Tug')->count()),
            Stat::make('Cargo', AisDataVessel::query()->where('vessel_type', 'Cargo')->count()),
        ];
    }
}
