<?php

namespace App\Http\Controllers;

use App\Models\BongkarMuatTerlambat;
use App\Models\DataMandiriPelaksanaanKapal;
use App\Models\InaportnetBongkarMuat;
use App\Models\Konsolidasi;
use App\Models\PanduTerlambat;
use App\Models\PanduTidakTerjadwal;
use App\Models\ReportGeofenceBongkarMuat;
use App\Models\TidakTerjadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function konsolidasi(Request $request)
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

        // Calculate summary data grouped by day
        $summaryData = DataMandiriPelaksanaanKapal::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->selectRaw('
    DATE(created_at) as date,
    SUM(CASE WHEN isPassing = 1 THEN 1 ELSE 0 END) AS passing_count,
    SUM(CASE WHEN isPandu = 1 THEN 1 ELSE 0 END) AS pandu_count,
    SUM(CASE WHEN isBongkarMuat = 1 THEN 1 ELSE 0 END) AS bongkar_muat_count
')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Initialize totals
        $total_data_mandiri_ais = 0;
        $total_data_inaportnet = 0;
        $total_tidak_terjadwal_bongkar = 0;
        $total_pandu_tidak_tejadwal = 0;
        $total_late_bongkar = 0;
        $total_late_pandu = 0;
        $total_tidak_teridentifikasi = 0;
        $total_pandu = 0;
        $total_muat = 0;
        $total_kapal = 0;

        // Calculate other totals from grouped data
        foreach ($summaryData as $summary) {
            $total_data_mandiri_ais += $summary['passing_count'];
            $total_data_inaportnet += $summary->pandu_count;
            $total_tidak_terjadwal_bongkar += $summary->bongkar_muat_count;

            // You can add more calculations here if needed
        }

        // Calculate total pandu, muat, and kapal
        $total_pandu = $total_data_inaportnet + $total_pandu_tidak_tejadwal + $total_late_pandu;
        $total_muat = $total_tidak_terjadwal_bongkar + $total_late_bongkar;
        $total_kapal = $total_pandu + $total_muat;

        // Modify the structure of the summary data
        $modifiedSummaryData = [];
        foreach ($summaryData as $summary) {
            $modifiedSummaryData[] = [
                'date' => $summary->date,
                'summary_data' => [
                    'pandu_count' => [
                        'total' => $total_pandu,
                        'detail' => [
                            'valid' => $summary->pandu_count,
                            'tidak_terjadwal' => $total_pandu_tidak_tejadwal,
                            'terlambat' => $total_late_pandu
                        ]
                    ],
                    'bongkar_muat_count' => [
                        'total' => $total_muat,
                        'detail' => [
                            'valid' => $summary->bongkar_muat_count,
                            'tidak_terjadwal' => $total_tidak_terjadwal_bongkar,
                            'terlambat' => $total_late_bongkar
                        ]
                    ],
                ],
            ];
        }

        $validDates = [];

        // Extract valid dates and initialize sumValidPanduCount
        $sumValidPanduCount = 0;
        foreach ($modifiedSummaryData as $report) {
            // Extract the date and valid pandu count for each report
            $date = $report["date"];
            $validDates[] = $date; // Collect valid dates
            $validPanduCount = (int)$report["summary_data"]["pandu_count"]["detail"]["valid"];

            // Accumulate valid pandu count
            $sumValidPanduCount += $validPanduCount;
        }

        // Remove duplicates from validDates
        $validDates = array_unique($validDates);

        // dd($modifiedSummaryData);

        $transformedData = [];

        foreach ($modifiedSummaryData as $data) {
            $transformedData[] = [
                "passing_count" => null,
                "pandu_count" => [
                    "total" => $data["summary_data"]["pandu_count"]["total"],
                    "detail" => [
                        "valid" => null,
                        "tidak_terjadwal" => $data["summary_data"]["pandu_count"]["detail"]["tidak_terjadwal"],
                        "terlambat" => $data["summary_data"]["pandu_count"]["detail"]["terlambat"]
                    ]
                ],
                "bongkar_muat_count" => [
                    "total" => $data["summary_data"]["bongkar_muat_count"]["total"],
                    "detail" => [
                        "valid" => null,
                        "tidak_terjadwal" => $data["summary_data"]["bongkar_muat_count"]["detail"]["tidak_terjadwal"],
                        "terlambat" => $data["summary_data"]["bongkar_muat_count"]["detail"]["terlambat"]
                    ]
                ]
            ];
        }

        $jsonData =  json_encode($transformedData, JSON_PRETTY_PRINT);

        $decodedData = json_decode($jsonData, true);

        $mergedData = [
            "passing_count" => null,
            "pandu_count" => [
                "total" => 0,
                "detail" => [
                    "valid" => null,
                    "tidak_terjadwal" => 0,
                    "terlambat" => 0
                ]
            ],
            "bongkar_muat_count" => [
                "total" => 0,
                "detail" => [
                    "valid" => null,
                    "tidak_terjadwal" => 0,
                    "terlambat" => 0
                ]
            ]
        ];

        foreach ($decodedData as $item) {
            $mergedData["pandu_count"]["total"] += $item["pandu_count"]["total"];
            $mergedData["bongkar_muat_count"]["total"] += $item["bongkar_muat_count"]["total"];
            $mergedData["bongkar_muat_count"]["detail"]["tidak_terjadwal"] += $item["bongkar_muat_count"]["detail"]["tidak_terjadwal"];
        }

        $summaryData = json_encode($mergedData, JSON_PRETTY_PRINT);


        Konsolidasi::create([
            'passing' => $summaryData->passing_count ?? 0,
            'pandu_tervalidasi' => $sumValidPanduCount ?? 0,
            'pandu_tidak_terjadwal' => $summaryData->pandu_count['detail']['tidak_terjadwal'] ?? 0,
            'pandu_terlambat' => $summaryData->pandu_count['detail']['terlambat'] ?? 0,
            'bongkar_muat_tervalidasi' => $summaryData->bongkar_muat_count['detail']['valid'] ?? 0,
            'bongkar_muat_tidak_terjadwal' => $summaryData->bongkar_muat_count['detail']['tidak_terjadwal'] ?? 0,
            'bongkar_muat_terlambat' => $summaryData->bongkar_muat_count['detail']['terlambat'] ?? 0,
            'total_kapal' => $total_kapal ?? 0,
        ]);


        return response()->json([
            'success' => true,
            'summary_data' => json_decode($summaryData),
            'total_kapal' => $total_kapal,
            'total_tidak_teridentifikasi' => $total_tidak_teridentifikasi - $total_kapal,
        ]);
    }


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

        $summaryData = DataMandiriPelaksanaanKapal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])
            ->selectRaw('
            SUM(CASE WHEN isPassing = 1 THEN 1 ELSE 0 END) AS passing_count,
            SUM(CASE WHEN isPandu = 1 THEN 1 ELSE 0 END) AS pandu_count,
            SUM(CASE WHEN isBongkarMuat = 1 THEN 1 ELSE 0 END) AS bongkar_muat_count
        ')
            ->first();

        $total_data_mandiri_ais = ReportGeofenceBongkarMuat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_data_inaportnet = InaportnetBongkarMuat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_tidak_terjadwal_bongkar = TidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_pandu_tidak_tejadwal = PanduTidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_late_bongkar = BongkarMuatTerlambat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_late_pandu = PanduTerlambat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_tidak_teridentifikasi = DataMandiriPelaksanaanKapal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_pandu = $summaryData['pandu_count'] + $total_pandu_tidak_tejadwal + $total_late_pandu;
        $total_muat = $summaryData['bongkar_muat_count'] + $total_tidak_terjadwal_bongkar + $total_late_bongkar;

        // Calculate total kapal
        $total_kapal = $summaryData['passing_count'] + $total_pandu + $total_muat;

        // Modify the structure of the summary data
        $summaryData['pandu_count'] = [
            'total' => $total_pandu,
            'detail' => [
                'valid' => $summaryData['pandu_count'],
                'tidak_terjadwal' => $total_pandu_tidak_tejadwal,
                'terlambat' => $total_late_pandu
            ]
        ];

        $summaryData['bongkar_muat_count'] = [
            'total' => $total_muat,
            'detail' => [
                'valid' => $summaryData['bongkar_muat_count'],
                'tidak_terjadwal' => $total_tidak_terjadwal_bongkar,
                'terlambat' => $total_late_bongkar
            ]
        ];

        // Return the modified summary report
        return response()->json([
            'success' => true,
            'summary_data' => $summaryData,
            'total_kapal' => $total_kapal,
            'total_tidak_teridentifikasi' => $total_tidak_teridentifikasi - $total_kapal,
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
