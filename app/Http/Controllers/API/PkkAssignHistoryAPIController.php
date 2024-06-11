<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePkkAssignHistoryAPIRequest;
use App\Http\Requests\API\UpdatePkkAssignHistoryAPIRequest;
use App\Models\PkkAssignHistory;
use App\Repositories\PkkAssignHistoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PkkAssignHistoryAPIController
 */
class PkkAssignHistoryAPIController extends AppBaseController
{
    private PkkAssignHistoryRepository $pkkAssignHistoryRepository;

    public function __construct(PkkAssignHistoryRepository $pkkAssignHistoryRepo)
    {
        $this->pkkAssignHistoryRepository = $pkkAssignHistoryRepo;
    }

    /**
     * Display a listing of the PkkAssignHistories.
     * GET|HEAD /pkk-assign-histories
     */
    public function index(Request $request): JsonResponse
    {
        $pkkAssignHistories = $this->pkkAssignHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pkkAssignHistories->toArray(), 'Pkk Assign Histories retrieved successfully');
    }

    /**
     * Store a newly created PkkAssignHistory in storage.
     * POST /pkk-assign-histories
     */
    public function store(CreatePkkAssignHistoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pkkAssignHistory = $this->pkkAssignHistoryRepository->create($input);

        return $this->sendResponse($pkkAssignHistory->toArray(), 'Pkk Assign History saved successfully');
    }

    /**
     * Display the specified PkkAssignHistory.
     * GET|HEAD /pkk-assign-histories/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PkkAssignHistory $pkkAssignHistory */
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            return $this->sendError('Pkk Assign History not found');
        }

        return $this->sendResponse($pkkAssignHistory->toArray(), 'Pkk Assign History retrieved successfully');
    }

    /**
     * Update the specified PkkAssignHistory in storage.
     * PUT/PATCH /pkk-assign-histories/{id}
     */
    public function update($id, UpdatePkkAssignHistoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PkkAssignHistory $pkkAssignHistory */
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            return $this->sendError('Pkk Assign History not found');
        }

        $pkkAssignHistory = $this->pkkAssignHistoryRepository->update($input, $id);

        return $this->sendResponse($pkkAssignHistory->toArray(), 'PkkAssignHistory updated successfully');
    }

    /**
     * Remove the specified PkkAssignHistory from storage.
     * DELETE /pkk-assign-histories/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PkkAssignHistory $pkkAssignHistory */
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            return $this->sendError('Pkk Assign History not found');
        }

        $pkkAssignHistory->delete();

        return $this->sendSuccess('Pkk Assign History deleted successfully');
    }
}
