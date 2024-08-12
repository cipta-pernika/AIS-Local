<?php

namespace App\Filament\Widgets;

use App\Models\AisData;
use App\Models\AisDataPosition;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

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

        $data = DB::table('ais_data_positions')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), DB::raw('COUNT(*) as aggregate'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

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