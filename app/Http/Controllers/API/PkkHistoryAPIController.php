<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePkkHistoryAPIRequest;
use App\Http\Requests\API\UpdatePkkHistoryAPIRequest;
use App\Models\PkkHistory;
use App\Repositories\PkkHistoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PkkHistoryAPIController
 */
class PkkHistoryAPIController extends AppBaseController
{
    private PkkHistoryRepository $pkkHistoryRepository;

    public function __construct(PkkHistoryRepository $pkkHistoryRepo)
    {
        $this->pkkHistoryRepository = $pkkHistoryRepo;
    }

    /**
     * Display a listing of the PkkHistories.
     * GET|HEAD /pkk-histories
     */
    public function index(Request $request): JsonResponse
    {
        $pkkHistories = $this->pkkHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pkkHistories->toArray(), 'Pkk Histories retrieved successfully');
    }

    /**
     * Store a newly created PkkHistory in storage.
     * POST /pkk-histories
     */
    public function store(CreatePkkHistoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pkkHistory = $this->pkkHistoryRepository->create($input);

        return $this->sendResponse($pkkHistory->toArray(), 'Pkk History saved successfully');
    }

    /**
     * Display the specified PkkHistory.
     * GET|HEAD /pkk-histories/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PkkHistory $pkkHistory */
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            return $this->sendError('Pkk History not found');
        }

        return $this->sendResponse($pkkHistory->toArray(), 'Pkk History retrieved successfully');
    }

    /**
     * Update the specified PkkHistory in storage.
     * PUT/PATCH /pkk-histories/{id}
     */
    public function update($id, UpdatePkkHistoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PkkHistory $pkkHistory */
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            return $this->sendError('Pkk History not found');
        }

        $pkkHistory = $this->pkkHistoryRepository->update($input, $id);

        return $this->sendResponse($pkkHistory->toArray(), 'PkkHistory updated successfully');
    }

    /**
     * Remove the specified PkkHistory from storage.
     * DELETE /pkk-histories/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PkkHistory $pkkHistory */
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            return $this->sendError('Pkk History not found');
        }

        $pkkHistory->delete();

        return $this->sendSuccess('Pkk History deleted successfully');
    }
}
