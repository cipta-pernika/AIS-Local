<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AisDataPositionExport;
use App\Models\AisDataPosition;
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

        if (!empty($dateRange) && is_array($dateRange)) {
            $decodedDateRange = json_decode($dateRange[0], true);

            $startDate = isset($decodedDateRange['startDate']) ? $decodedDateRange['startDate'] : null;
            $endDate = isset($decodedDateRange['endDate']) ? $decodedDateRange['endDate'] : null;
        } else {
            $startDate = $endDate = null;
        }

        $exportData = AisDataPosition::where(function ($query) use ($startDate, $endDate, $vessels) {
            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('timestamp', [$startDate, $endDate]);
            }
            if (!empty($vessels)) {
                $query->whereIn('vessel_id', $vessels);
            }
        })
        ->take(1000) // Batasi hingga 100 baris
        ->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.aisdataposition', ['data' => $exportData]);
            return $pdf->download('TRACKING-' . Carbon::now() . '.pdf');
        }

        return Excel::download(new AisDataPositionExport($exportData), 'TRACKING-' . Carbon::now() . '.xlsx');
    }
}
