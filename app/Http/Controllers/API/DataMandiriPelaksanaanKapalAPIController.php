<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDataMandiriPelaksanaanKapalAPIRequest;
use App\Http\Requests\API\UpdateDataMandiriPelaksanaanKapalAPIRequest;
use App\Models\DataMandiriPelaksanaanKapal;
use App\Repositories\DataMandiriPelaksanaanKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

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
        $perPage = $request->get('limit', 10);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            $allAddons = DataMandiriPelaksanaanKapal::whereHas('aisDataVessel', function ($query) use ($searchTerm) {
                $query->where('vessel_name', 'like', '%' . $searchTerm . '%');
            })->get();
        } else {
            // Retrieve all airlines using the repository's "all" method
            $allAddons = $this->dataMandiriPelaksanaanKapalRepository->all(
                $request->except(['skip', 'limit'])
            );
        }

        // Manually paginate the results
        $addons = $allAddons->slice(
            $request->get('skip', 0),
            $perPage
        )->values(); // Reset keys to start from 0

        $addons->load([
            'aisDataVessel', 'aisDataPosition', 'geofence', 'imptPelayananKapal', 'imptPenggunaanAlat', 'reportGeofence',
            'inaportnetBongkarMuat', 'pbkmKegiatanPemanduan'
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
