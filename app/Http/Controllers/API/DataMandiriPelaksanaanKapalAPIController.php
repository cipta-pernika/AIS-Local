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
        $dataMandiriPelaksanaanKapals = $this->dataMandiriPelaksanaanKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($dataMandiriPelaksanaanKapals->toArray(), 'Data Mandiri Pelaksanaan Kapals retrieved successfully');
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
