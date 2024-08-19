<?php

namespace App\Http\Controllers;

use AisDataPosition;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AisDataPositionExport;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function exportais(){
        
    }

    public function exportaisdatapositions(){

        $dateRange = request('dateRange', []);

        if (!empty($dateRange) && is_array($dateRange)) {
            $decodedDateRange = json_decode($dateRange[0], true);

            $startDate = isset($decodedDateRange['startDate']) ? $decodedDateRange['startDate'] : null;
            $endDate = isset($decodedDateRange['endDate']) ? $decodedDateRange['endDate'] : null;
        } else {
            $startDate = $endDate = null;
        }

        $exportData = AisDataPosition::where(function ($query) use ($startDate, $endDate) {
            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('timestamp', [$startDate, $endDate]);
            }
        })->get();

        return Excel::download(new AisDataPositionExport($exportData), 'TRACKING-' . Carbon::now() . '.xlsx');
        
    }
}
