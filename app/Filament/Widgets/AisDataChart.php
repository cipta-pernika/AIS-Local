<?php

namespace App\Filament\Widgets;

use App\Models\AisData;
use App\Models\AisDataPosition;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AisDataChart extends ChartWidget
{
    protected static ?string $heading = 'AIS DATA';

    public function getDescription(): ?string
    {
        return 'Diagram Statistik AIS Data';
    }

    protected function getData(): array
    {
        $startDate = now()->subYear();
        $endDate = now();

        $data = Trend::model(AisDataPosition::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perMonth()
            ->count();

        $aggregates = $data->pluck('aggregate');
        $dates = $data->pluck('date');

        return [
            'datasets' => [
                [
                    'label' => 'Ais Data',
                    'data' => $aggregates,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}