<?php

namespace App\Http\Controllers;

use App\Models\DataMandiriPelaksanaanKapal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function summaryreport(Request $request)
    {
        // Manually validate request parameters
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $startDateTime = Carbon::parse($request->start_date)->startOfDay();
        $endDateTime = Carbon::parse($request->end_date)->endOfDay();

        // Retrieve data based on the provided start and end dates
        $summaryData = DataMandiriPelaksanaanKapal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])
            ->selectRaw('
            SUM(CASE WHEN isPassing = 1 THEN 1 ELSE 0 END) AS passing_count,
            SUM(CASE WHEN isPandu = 1 THEN 1 ELSE 0 END) AS pandu_count,
            SUM(CASE WHEN isBongkarMuat = 1 THEN 1 ELSE 0 END) AS bongkar_muat_count
        ')
            ->first();

        // Return the summary report
        return response()->json([
            'success' => true,
            'summary_data' => $summaryData,
        ]);
    }
}
