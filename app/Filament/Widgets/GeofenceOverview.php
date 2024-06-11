<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\EventTracking;
use App\Models\Geofence;
use Illuminate\Support\Carbon;

class GeofenceOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $startDate = filled($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            now()->subDays(7);

        $endDate = filled($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $enterGeofenceCount = EventTracking::where('event_id', 9)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $exitGeofenceCount = EventTracking::where('event_id', 10)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pelabuhanStats = $this->getPelabuhanStats($startDate, $endDate);

        // $insideGeofenceCount = EventTracking::where('event_id', 9)
        //     ->whereNotIn('event_id', [10])
        //     ->whereBetween('created_at', [$startDate, $endDate])
        //     ->count();
        $insideGeofenceCount = $enterGeofenceCount - $exitGeofenceCount;

        $enterPercentageChange = $this->calculatePercentageChange($enterGeofenceCount, $startDate, $endDate, 9);
        $insidePercentageChange = $this->calculatePercentageChange($insideGeofenceCount, $startDate, $endDate, 9, true);
        $exitPercentageChange = $this->calculatePercentageChange($exitGeofenceCount, $startDate, $endDate, 10);

        return [
            Stat::make('Masuk Geofence', $enterGeofenceCount)
                ->description($this->getIncreaseDescription($enterPercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->getChartData(9, $startDate, $endDate))
                ->color('success'),
            Stat::make('Berada di dalam Geofence', $insideGeofenceCount)
                ->description($this->getIncreaseDescription($insidePercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart($this->getChartData(9, $startDate, $endDate, true))
                ->color('danger'),
            Stat::make('Keluar Geofence', $exitGeofenceCount)
                ->description($this->getIncreaseDescription($exitPercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->getChartData(10, $startDate, $endDate))
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

    protected function getPelabuhanStats(Carbon $startDate, Carbon $endDate): array
    {
        $pelabuhanStats = [];

        // Get distinct geofence_ids from Geofence
        $geofenceIds = Geofence::distinct('id')->pluck('id');

        foreach ($geofenceIds as $geofenceId) {
            $geofence = Geofence::find($geofenceId);

            // Skip if there's no associated Geofence
            if (!$geofence) {
                continue;
            }

            $pelabuhanName = $geofence->pelabuhan_name;

            $enterPelabuhanCount = EventTracking::where('event_id', 9)
                ->where('geofence_id', $geofenceId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $exitPelabuhanCount = EventTracking::where('event_id', 10)
                ->where('geofence_id', $geofenceId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $insidePelabuhanCount = $enterPelabuhanCount - $exitPelabuhanCount;

            $enterPercentageChange = $this->calculatePercentageChange($enterPelabuhanCount, $startDate, $endDate, 9);
            $insidePercentageChange = $this->calculatePercentageChange($insidePelabuhanCount, $startDate, $endDate, 9, true);
            $exitPercentageChange = $this->calculatePercentageChange($exitPelabuhanCount, $startDate, $endDate, 10);

            $pelabuhanStats[] = Stat::make("Masuk {$pelabuhanName}", $enterPelabuhanCount)
                ->description($this->getIncreaseDescription($enterPercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->getChartData(9, $startDate, $endDate, false, $geofenceId))
                ->color('success');

            $pelabuhanStats[] = Stat::make("Berada di dalam {$pelabuhanName}", $insidePelabuhanCount)
                ->description($this->getIncreaseDescription($insidePercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart($this->getChartData(9, $startDate, $endDate, true, $geofenceId))
                ->color('danger');

            $pelabuhanStats[] = Stat::make("Keluar {$pelabuhanName}", $exitPelabuhanCount)
                ->description($this->getIncreaseDescription($exitPercentageChange))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->getChartData(10, $startDate, $endDate, false, $geofenceId))
                ->color('success');
        }

        return $pelabuhanStats;
    }
}
