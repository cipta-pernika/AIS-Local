<?php

namespace App\Filament\Widgets;

use App\Models\AisData;
use App\Models\AisDataPosition;
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
        $data = Trend::model(AisDataPosition::class)
            ->between(
                start: now()->subYear(),
                end: now(),
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
