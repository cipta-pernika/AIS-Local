<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnomalyVariableAPIRequest;
use App\Http\Requests\API\UpdateAnomalyVariableAPIRequest;
use App\Models\AnomalyVariable;
use App\Repositories\AnomalyVariableRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AnomalyVariableAPIController
 */
class AnomalyVariableAPIController extends AppBaseController
{
    private AnomalyVariableRepository $anomalyVariableRepository;

    public function __construct(AnomalyVariableRepository $anomalyVariableRepo)
    {
        $this->anomalyVariableRepository = $anomalyVariableRepo;
    }

    /**
     * Display a listing of the AnomalyVariables.
     * GET|HEAD /anomaly-variables
     */
    public function index(Request $request): JsonResponse
    {
        $anomalyVariables = $this->anomalyVariableRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($anomalyVariables->toArray(), 'Anomaly Variables retrieved successfully');
    }

    /**
     * Store a newly created AnomalyVariable in storage.
     * POST /anomaly-variables
     */
    public function store(CreateAnomalyVariableAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $anomalyVariable = $this->anomalyVariableRepository->create($input);

        return $this->sendResponse($anomalyVariable->toArray(), 'Anomaly Variable saved successfully');
    }

    /**
     * Display the specified AnomalyVariable.
     * GET|HEAD /anomaly-variables/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var AnomalyVariable $anomalyVariable */
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            return $this->sendError('Anomaly Variable not found');
        }

        return $this->sendResponse($anomalyVariable->toArray(), 'Anomaly Variable retrieved successfully');
    }

    /**
     * Update the specified AnomalyVariable in storage.
     * PUT/PATCH /anomaly-variables/{id}
     */
    public function update($id, UpdateAnomalyVariableAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var AnomalyVariable $anomalyVariable */
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            return $this->sendError('Anomaly Variable not found');
        }

        $anomalyVariable = $this->anomalyVariableRepository->update($input, $id);

        return $this->sendResponse($anomalyVariable->toArray(), 'AnomalyVariable updated successfully');
    }

    /**
     * Remove the specified AnomalyVariable from storage.
     * DELETE /anomaly-variables/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var AnomalyVariable $anomalyVariable */
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            return $this->sendError('Anomaly Variable not found');
        }

        $anomalyVariable->delete();

        return $this->sendSuccess('Anomaly Variable deleted successfully');
    }
}
