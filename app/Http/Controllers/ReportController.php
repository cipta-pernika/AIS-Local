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

        // Modify the structure of the summary data
        $summaryData['pandu_count'] = [
            'pandu_count' => $summaryData['pandu_count'],
            'detail' => [
                'valid' => '5',
                'tidak_terjadwal' => '10',
                'terlambat' => '4'
            ]
        ];

        $summaryData['bongkar_muat_count'] = [
            'bongkar_muat_count' => $summaryData['bongkar_muat_count'],
            'detail' => [
                'valid' => '5',
                'tidak_terjadwal' => '10',
                'terlambat' => '4'
            ]
        ];

        // Remove the original pandu_count and bongkar_muat_count keys
        unset($summaryData['pandu_count']);
        unset($summaryData['bongkar_muat_count']);

        // Return the modified summary report
        return response()->json([
            'success' => true,
            'summary_data' => $summaryData,
        ]);
    }

    public function datamandiri(Request $request)
    {
        $data = DataMandiriPelaksanaanKapal::whereNotNull('ais_data_vessel_id')
            ->whereNotNull('inaportnet_bongkar_muat_id')
            ->whereNotNull('inaportnet_pergerakan_kapal_id')
            ->whereNotNull('impt_pelayanan_kapal_id')
            ->whereNotNull('impt_penggunaan_alat_id')
            ->whereNotNull('pbkm_kegiatan_pemanduan_id')
            ->whereNotNull('geofence_id')
            ->whereNotNull('ais_data_position_id')
            ->whereNotNull('report_geofence_id')
            ->whereNotNull('report_geofence_bongkar_muat_id')
            ->with(
                'aisDataVessel',
                'aisDataPosition',
                'geofence',
                'imptPelayananKapal',
                'imptPenggunaanAlat',
                'reportGeofence',
                'inaportnetBongkarMuat',
                'pbkmKegiatanPemanduan'
            )->get();

        $perPage = $request->get('limit', 10);

        // Manually paginate the results
        $paginatedData = $data->slice(
            $request->get('skip', 0),
            $perPage
        )->values();

        return response()->json([
            'data' => $paginatedData->toArray(), // Paginated data
            'pagination' => [
                'total' => $data->count(), // Total number of records
                'per_page' => $perPage, // Records per page
                'current_page' => $request->get('skip', 0) / $perPage + 1, // Current page number
                'last_page' => ceil($data->count() / $perPage), // Last page number
            ],
            'success' => true,
            'message' => 'Data Mandiri Pelaksanaan retrieved successfully'
        ]);
    }
}
