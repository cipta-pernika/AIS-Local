<?php

namespace App\Filament\Widgets;

use App\Models\AisData;
use App\Models\AisDataPosition;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AisDataChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'AIS DATA';

    public function getDescription(): ?string
    {
        return 'Diagram Statistik AIS Data';
    }

    protected function getData(): array
    {
        $startDate = filled($this->filters['startDate'] ?? null) ?
            \Illuminate\Support\Carbon::parse($this->filters['startDate']) :
            now()->subYear();

        $endDate = filled($this->filters['endDate'] ?? null) ?
            \Illuminate\Support\Carbon::parse($this->filters['endDate']) :
            now();

        // $pelabuhanId = $this->filters['pelabuhan_id'] ?? null;

        // $query = AisDataPosition::query()
        //     ->when($pelabuhanId, function ($query) use ($pelabuhanId) {
        //         $query->whereHas('sensorData.sensor', function ($subquery) use ($pelabuhanId) {
        //             $subquery->where('datalogger_id', $pelabuhanId);
        //         });
        //     })
        //     ->whereBetween('created_at', [$startDate, $endDate]);

        // $data = $query->selectRaw('COUNT(*) as aggregate, DATE_FORMAT(created_at, "%Y-%m") as date')
        //     ->groupBy('date')
        //     ->get();

        // $data = collect($data);

        $data = Trend::model(AisDataPosition::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Ais Data',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
