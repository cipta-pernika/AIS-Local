<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AisDataPositionExport;
use App\Exports\AisDataVesselExport;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportais(){
        
    }

    public function aisdatapositionsexport(){

        $dateRange = request('dateRange', []);
        $vessels = request('vessels', []);
        $format = request('format', 'xlsx');
        $timezone = request('timezone', 'UTC');

        if (!empty($dateRange) && is_array($dateRange)) {
            $decodedDateRange = json_decode($dateRange[0], true);

            $startDate = isset($decodedDateRange['startDate']) ? $decodedDateRange['startDate'] : null;
            $endDate = isset($decodedDateRange['endDate']) ? $decodedDateRange['endDate'] : null;
        } else {
            $startDate = $endDate = null;
        }

        $exportData = AisDataPosition::where(function ($query) use ($startDate, $endDate, $vessels, $timezone) {
            if (!empty($startDate) && !empty($endDate)) {
                $startDateTime = Carbon::parse($startDate)->tz($timezone);
                $endDateTime = Carbon::parse($endDate)->tz($timezone);
                $query->whereBetween('timestamp', [$startDateTime, $endDateTime]);
            }
            if (!empty($vessels)) {
                $query->whereIn('vessel_id', $vessels);
            }
        })
        ->get()
        ->map(function($item) use ($timezone) {
            $item->timestamp = Carbon::parse($item->timestamp)->tz($timezone);
            return $item;
        });

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('pdf.historyreport', ['data' => $exportData]);
            return $pdf->download('TRACKING-' . Carbon::now() . '.pdf');
        }

        return Excel::download(new AisDataPositionExport($exportData), 'TRACKING-' . Carbon::now() . '.xlsx');
    }
    public function aisdatapositionsexportvessel(){

        $dateRange = request('dateRange', []);
        $format = request('format', 'xlsx');
        $vessels = request('vessels', []); // Tambahkan ini untuk mendapatkan daftar vessel

        if (!empty($dateRange) && is_array($dateRange)) {
            $decodedDateRange = json_decode($dateRange[0], true);

            $startDate = isset($decodedDateRange['startDate']) ? $decodedDateRange['startDate'] : null;
            $endDate = isset($decodedDateRange['endDate']) ? $decodedDateRange['endDate'] : null;
        } else {
            $startDate = $endDate = null;
        }

        $exportData = AisDataVessel::join('ais_data_positions', 'ais_data_vessels.id', '=', 'ais_data_positions.vessel_id')
            ->where(function ($query) use ($startDate, $endDate, $vessels) {
                if (!empty($startDate) && !empty($endDate)) {
                    $query->whereBetween('ais_data_positions.timestamp', [$startDate, $endDate]);
                }
                if (!empty($vessels)) {
                    $query->whereIn('ais_data_vessels.id', $vessels);
                }
            })
            ->select('ais_data_vessels.*', 'ais_data_positions.timestamp') // Pilih kolom yang diperlukan
            ->groupBy('ais_data_vessels.id') // Kelompokkan berdasarkan ID kapal untuk menghindari duplikasi
            ->take(100) // Batasi hingga 100 baris
            ->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('pdf.vesselreport', ['data' => $exportData]);
            return $pdf->download('VESSEL-' . Carbon::now() . '.pdf');
        }

        return Excel::download(new AisDataVesselExport($exportData), 'VESSEL-' . Carbon::now() . '.xlsx');
    }
}
