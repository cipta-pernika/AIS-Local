<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDataMandiriPelaksanaanKapalAPIRequest;
use App\Http\Requests\API\UpdateDataMandiriPelaksanaanKapalAPIRequest;
use App\Models\DataMandiriPelaksanaanKapal;
use App\Repositories\DataMandiriPelaksanaanKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\BongkarMuatTerlambat;
use App\Models\PanduTerlambat;
use App\Models\PanduTidakTerjadwal;
use App\Models\TidakTerjadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class DataMandiriPelaksanaanKapalAPIController
 */
class DataMandiriPelaksanaanKapalAPIController extends AppBaseController
{
    private DataMandiriPelaksanaanKapalRepository $dataMandiriPelaksanaanKapalRepository;

    public function __construct(DataMandiriPelaksanaanKapalRepository $dataMandiriPelaksanaanKapalRepo)
    {
        $this->dataMandiriPelaksanaanKapalRepository = $dataMandiriPelaksanaanKapalRepo;
    }

    /**
     * Display a listing of the DataMandiriPelaksanaanKapals.
     * GET|HEAD /data-mandiri-pelaksanaan-kapals
     */
    public function index(Request $request): JsonResponse
    {
        // Set default values for start date and end date if they are not provided
        $startDateTime = Carbon::parse($request->start_date ?? now())->startOfDay();
        $endDateTime = Carbon::parse($request->end_date ?? now()->addDay())->endOfDay();

        $perPage = $request->get('limit', 10);

        // Initialize the main query builder with constraints based on start_date and end_date
        $mainQuery = DataMandiriPelaksanaanKapal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->whereNotNull('geofence_id')->whereNotNull('pnbp_jasa_labuh_kapal');
        // $mainQuery = DataMandiriPelaksanaanKapal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime]);

        // Apply search filter if provided
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $mainQuery->whereHas('aisDataVessel', function ($query) use ($searchTerm) {
                $query->where('vessel_name', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply filter by isPassing if provided
        if ($request->has('isPassing')) {
            $isPassing = (int)$request->input('isPassing');
            $mainQuery->where('isPassing', $isPassing);
        }

        // Apply filter by isPanduValid if provided
        if ($request->has('isPanduValid')) {
            $isPanduValid = (int)$request->input('isPanduValid');
            $mainQuery->where('isPandu', $isPanduValid);
        }

        // Apply filter by isBongkarMuatValid if provided
        if ($request->has('isBongkarMuatValid')) {
            $isBongkarMuatValid = (int)$request->input('isBongkarMuatValid');
            $mainQuery->where('isBongkarMuat', $isBongkarMuatValid);
        }

        // Check for specific conditions and apply corresponding queries
        if ($request->has('isPanduTidakTerjadwal')) {
            // $query = PanduTidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->whereNotNull('geofence_id');
            $query = PanduTidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime]);
        } elseif ($request->has('isPanduLate')) {
            $query = PanduTerlambat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime]);
        } elseif ($request->has('isBongkarTidakTerjadwal')) {
            // $query = TidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->whereNotNull('geofence_id');
            $query = TidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime]);
        } elseif ($request->has('isBongkarLate')) {
            $query = BongkarMuatTerlambat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime]);
        } else {
            // Default to the main query if no specific condition is provided
            // $query = $mainQuery;
            $query = DataMandiriPelaksanaanKapal::select(
                'ais_data_vessel_id',
                'inaportnet_bongkar_muat_id',
                'inaportnet_pergerakan_kapal_id',
                'impt_pelayanan_kapal_id',
                'impt_penggunaan_alat_id',
                'pbkm_kegiatan_pemanduan_id',
                'isPassing',
                'isPandu',
                'isBongkarMuat',
                'geofence_id',
                'ais_data_position_id',
                'report_geofence_id',
                'report_geofence_bongkar_muat_id',
                'report_geofence_pandu_id',
                'pnbp_jasa_labuh_kapal',
                'pnbp_jasa_vts_kapal_domestik',
                'pnbp_jasa_vts_kapal_asing'
            ) // Select the columns you need from DataMandiriPelaksanaanKapal
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])
                ->whereNotNull('geofence_id')
                ->whereNotNull('pnbp_jasa_labuh_kapal')
                ->union(
                    PanduTerlambat::select(
                        'ais_data_vessel_id',
                        'inaportnet_bongkar_muat_id',
                        'inaportnet_pergerakan_kapal_id',
                        'impt_pelayanan_kapal_id',
                        'impt_penggunaan_alat_id',
                        'pbkm_kegiatan_pemanduan_id',
                        'isPassing',
                        'isPandu',
                        'isBongkarMuat',
                        'geofence_id',
                        'ais_data_position_id',
                        'report_geofence_id',
                        'report_geofence_bongkar_muat_id',
                        'report_geofence_pandu_id',
                        'pnbp_jasa_labuh_kapal',
                        'pnbp_jasa_vts_kapal_domestik',
                        'pnbp_jasa_vts_kapal_asing'
                    ) // Select the same columns you selected from DataMandiriPelaksanaanKapal
                        ->whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])
                );
        }

        // Retrieve filtered data based on the selected query
        $allAddons = $query->get();

        // Manually paginate the results
        $addons = $allAddons->slice(
            $request->get('skip', 0),
            $perPage
        )->values(); // Reset keys to start from 0

        $addons->load([
            'aisDataVessel', 'aisDataPosition', 'geofence', 'imptPelayananKapal', 'imptPenggunaanAlat', 'reportGeofence', 'reportGeofence.geofence',
            'inaportnetBongkarMuat', 'pbkmKegiatanPemanduan', 'reportGeofenceBongkarMuat', 'reportGeofenceBongkarMuat.geofence',
            'reportGeofencePandu', 'reportGeofencePandu.geofence'
        ]);

        // Return a JSON response containing the paginated data and pagination meta
        return $this->sendResponse([
            'data' => $addons->toArray(), // Paginated data
            'pagination' => [
                'total' => $allAddons->count(), // Total number of records
                'per_page' => $perPage, // Records per page
                'current_page' => $request->get('skip', 0) / $perPage + 1, // Current page number
                'last_page' => ceil($allAddons->count() / $perPage), // Last page number
            ],
        ], 'Data Mandiri Pelaksanaan retrieved successfully');
    }


    /**
     * Store a newly created DataMandiriPelaksanaanKapal in storage.
     * POST /data-mandiri-pelaksanaan-kapals
     */
    public function store(CreateDataMandiriPelaksanaanKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->create($input);

        return $this->sendResponse($dataMandiriPelaksanaanKapal->toArray(), 'Data Mandiri Pelaksanaan Kapal saved successfully');
    }

    /**
     * Display the specified DataMandiriPelaksanaanKapal.
     * GET|HEAD /data-mandiri-pelaksanaan-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var DataMandiriPelaksanaanKapal $dataMandiriPelaksanaanKapal */
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            return $this->sendError('Data Mandiri Pelaksanaan Kapal not found');
        }

        return $this->sendResponse($dataMandiriPelaksanaanKapal->toArray(), 'Data Mandiri Pelaksanaan Kapal retrieved successfully');
    }

    /**
     * Update the specified DataMandiriPelaksanaanKapal in storage.
     * PUT/PATCH /data-mandiri-pelaksanaan-kapals/{id}
     */
    public function update($id, UpdateDataMandiriPelaksanaanKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DataMandiriPelaksanaanKapal $dataMandiriPelaksanaanKapal */
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            return $this->sendError('Data Mandiri Pelaksanaan Kapal not found');
        }

        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->update($input, $id);

        return $this->sendResponse($dataMandiriPelaksanaanKapal->toArray(), 'DataMandiriPelaksanaanKapal updated successfully');
    }

    /**
     * Remove the specified DataMandiriPelaksanaanKapal from storage.
     * DELETE /data-mandiri-pelaksanaan-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var DataMandiriPelaksanaanKapal $dataMandiriPelaksanaanKapal */
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            return $this->sendError('Data Mandiri Pelaksanaan Kapal not found');
        }

        $dataMandiriPelaksanaanKapal->delete();

        return $this->sendSuccess('Data Mandiri Pelaksanaan Kapal deleted successfully');
    }
}
