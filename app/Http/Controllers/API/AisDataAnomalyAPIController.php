<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAisDataAnomalyAPIRequest;
use App\Http\Requests\API\UpdateAisDataAnomalyAPIRequest;
use App\Models\AisDataAnomaly;
use App\Repositories\AisDataAnomalyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AisDataAnomalyAPIController
 */
class AisDataAnomalyAPIController extends AppBaseController
{
    private AisDataAnomalyRepository $aisDataAnomalyRepository;

    public function __construct(AisDataAnomalyRepository $aisDataAnomalyRepo)
    {
        $this->aisDataAnomalyRepository = $aisDataAnomalyRepo;
    }

    /**
     * Display a listing of the AisDataAnomalies.
     * GET|HEAD /ais-data-anomalies
     */
    public function index(Request $request): JsonResponse
    {
        $aisDataAnomalies = $this->aisDataAnomalyRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($aisDataAnomalies->toArray(), 'Ais Data Anomalies retrieved successfully');
    }

    /**
     * Store a newly created AisDataAnomaly in storage.
     * POST /ais-data-anomalies
     */
    public function store(CreateAisDataAnomalyAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $aisDataAnomaly = $this->aisDataAnomalyRepository->create($input);

        return $this->sendResponse($aisDataAnomaly->toArray(), 'Ais Data Anomaly saved successfully');
    }

    /**
     * Display the specified AisDataAnomaly.
     * GET|HEAD /ais-data-anomalies/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var AisDataAnomaly $aisDataAnomaly */
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            return $this->sendError('Ais Data Anomaly not found');
        }

        return $this->sendResponse($aisDataAnomaly->toArray(), 'Ais Data Anomaly retrieved successfully');
    }

    /**
     * Update the specified AisDataAnomaly in storage.
     * PUT/PATCH /ais-data-anomalies/{id}
     */
    public function update($id, UpdateAisDataAnomalyAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var AisDataAnomaly $aisDataAnomaly */
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            return $this->sendError('Ais Data Anomaly not found');
        }

        $aisDataAnomaly = $this->aisDataAnomalyRepository->update($input, $id);

        return $this->sendResponse($aisDataAnomaly->toArray(), 'AisDataAnomaly updated successfully');
    }

    /**
     * Remove the specified AisDataAnomaly from storage.
     * DELETE /ais-data-anomalies/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var AisDataAnomaly $aisDataAnomaly */
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            return $this->sendError('Ais Data Anomaly not found');
        }

        $aisDataAnomaly->delete();

        return $this->sendSuccess('Ais Data Anomaly deleted successfully');
    }
}
