<?php

namespace App\Filament\Widgets;

use App\Models\ImptPelayananKapal;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PelayananKapalChart extends ChartWidget
{
    
    protected static ?string $heading = 'Grafik Konsesi Pelayanan Kapal IMPT Tahun';

    public ?string $filter = 'month';

    public function getDescription(): ?string
    {
        return 'Diagram Statistik Data Konsesi Tahun Anggaran ' . Carbon::now()->year;
    }

    protected function getData(): array
    {
        self::$heading .= ' ' . Carbon::now()->year;
        $currentYear = now()->year;

        $data = ImptPelayananKapal::selectRaw("LPAD(MONTH(waktu_kedatangan), 2, '0') AS bulan")
            ->selectRaw("COALESCE(SUM(SUBSTRING(jumlah_biaya, 1, 10)), 0) AS jumlah_biaya")
            ->selectRaw("COALESCE(SUM(SUBSTRING(jumlah_pnbp, 1, 10)), 0) AS jumlah_pnbp_konseksi")
            ->whereYear('waktu_kedatangan', '=', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $array_bulan = collect(range(1, 12))->map(function ($month) {
            return str_pad($month, 2, '0', STR_PAD_LEFT);
        });

        $array_biaya = $data->pluck('jumlah_biaya')->toArray();
        $array_JUMLAH_PNBP_KONSESI = $data->pluck('jumlah_pnbp_konseksi')->toArray();

        $filteredData = $data->keyBy('bulan');
        $filtered_biaya = $array_bulan->map(function ($bulan) use ($filteredData) {
            return $filteredData->has($bulan) ? floatval($filteredData[$bulan]['jumlah_biaya']) : 0;
        })->toArray();

        $filtered_JUMLAH_PNBP_KONSESI = $array_bulan->map(function ($bulan) use ($filteredData) {
            return $filteredData->has($bulan) ? floatval($filteredData[$bulan]['jumlah_pnbp_konseksi']) : 0;
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendapatan',
                    'data' => $filtered_biaya,
                ],
                [
                    'label' => 'Jumlah Konsesi',
                    'data' => $filtered_JUMLAH_PNBP_KONSESI,
                    'backgroundColor' => '#D9534F',
                    'borderColor' => '#D9534F',
                ],
            ],
            'labels' => $array_bulan->map(function ($month) {
                return Carbon::createFromFormat('m', $month)->format('M-y');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
