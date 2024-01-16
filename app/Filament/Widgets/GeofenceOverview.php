<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\EventTracking;
use Illuminate\Support\Carbon;

class GeofenceOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $today = Carbon::today();
        $sevenDaysAgo = $today->copy()->subDays(7);

        $enterGeofenceCount = EventTracking::where('event_id', 9)
            ->whereBetween('created_at', [$sevenDaysAgo, $today])
            ->count();

        $exitGeofenceCount = EventTracking::where('event_id', 10)
            ->whereBetween('created_at', [$sevenDaysAgo, $today])
            ->count();

        $insideGeofenceCount = EventTracking::where('event_id', 9)
            ->whereNotIn('event_id', [10]) // Exclude events with event_id 10 (exiting geofence)
            ->whereBetween('created_at', [$sevenDaysAgo, $today])
            ->count();

        $enterPercentageChange = $this->calculatePercentageChange($enterGeofenceCount, $sevenDaysAgo, $today, 9);
        $insidePercentageChange = $this->calculatePercentageChange($insideGeofenceCount, $sevenDaysAgo, $today, 9, true);
        $exitPercentageChange = $this->calculatePercentageChange($exitGeofenceCount, $sevenDaysAgo, $today, 10);

        return [
            Stat::make('Masuk Geofence', $enterGeofenceCount)
                ->description($this->getIncreaseDescription($enterPercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->getChartData(9, $sevenDaysAgo, $today))
                ->color('success'),
            Stat::make('Berada di dalam Geofence', $insideGeofenceCount)
                ->description($this->getIncreaseDescription($insidePercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart($this->getChartData(9, $sevenDaysAgo, $today, true))
                ->color('danger'),
            Stat::make('Keluar Geofence', $exitGeofenceCount)
                ->description($this->getIncreaseDescription($exitPercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->getChartData(10, $sevenDaysAgo, $today))
                ->color('success'),
        ];
    }

    protected function getChartData(int $eventId, Carbon $startDate, Carbon $endDate, $inside = false): array
    {
        $query = EventTracking::where('event_id', $eventId)
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($inside) {
            $query->whereNotIn('event_id', [10]); // Exclude events with event_id 10 (exiting geofence)
        }

        $data = $query->groupBy('date')
            ->orderBy('date')
            ->get([
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('COUNT(*) as count'),
            ]);

        return $data->pluck('count')->toArray();
    }

    protected function getIncreaseDescription(int $percentage): string
    {
        return ($percentage > 0) ? "{$percentage}% increase" : "{$percentage}% decrease";
    }

    protected function calculatePercentageChange(int $count, Carbon $startDate, Carbon $endDate, int $eventId, $inside = false): float
    {
        $previousCount = EventTracking::where('event_id', $eventId)
            ->whereBetween('created_at', [$startDate->copy()->subDays(7), $startDate->copy()->subDay()])
            ->count();

        return ($previousCount !== 0) ? (($count - $previousCount) / $previousCount) * 100 : 0;
    }
}
