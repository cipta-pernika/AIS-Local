<?php

namespace App\Filament\Widgets;

use App\Models\AisDataVessel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VesselTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $startDate = filled($this->filters['startDate'] ?? null) ?
            \Illuminate\Support\Carbon::parse($this->filters['startDate']) :
            now()->subYear();

        $endDate = filled($this->filters['endDate'] ?? null) ?
            \Illuminate\Support\Carbon::parse($this->filters['endDate']) :
            now();

        return [
            Stat::make('Fishing', AisDataVessel::query()->where('vessel_type', 'Fishing')->whereBetween('created_at', [$startDate, $endDate])->count()),
            Stat::make('Tug', AisDataVessel::query()->where('vessel_type', 'Tug')->whereBetween('created_at', [$startDate, $endDate])->count()),
            Stat::make('Cargo', AisDataVessel::query()->where('vessel_type', 'Cargo')->whereBetween('created_at', [$startDate, $endDate])->count()),
        ];
    }
}
