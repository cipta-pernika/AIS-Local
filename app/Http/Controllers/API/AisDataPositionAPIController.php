<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAisDataPositionAPIRequest;
use App\Http\Requests\API\UpdateAisDataPositionAPIRequest;
use App\Models\AisDataPosition;
use App\Repositories\AisDataPositionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AisDataPositionAPIController
 */
class AisDataPositionAPIController extends AppBaseController
{
    private AisDataPositionRepository $aisDataPositionRepository;

    public function __construct(AisDataPositionRepository $aisDataPositionRepo)
    {
        $this->aisDataPositionRepository = $aisDataPositionRepo;
    }

    /**
     * Display a listing of the AisDataPositions with pagination.
     * GET|HEAD /ais-data-positions
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('limit', 15); // Default to 15 if limit is not provided

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            // Load the results directly from the model
            $allAisDataPositions = AisDataPosition::where('name', 'like', '%' . $searchTerm . '%')->get();
        } else {
            // Retrieve all AisDataPositions using the repository's "all" method
            $allAisDataPositions = $this->aisDataPositionRepository->all(
                $request->except(['skip', 'limit'])
            );
        }

        // Manually paginate the results
        $aisDataPositions = $allAisDataPositions->slice(
            $request->get('skip', 0),
            $perPage
        )->values(); // Reset keys to start from 0

        $aisDataPositions->load('vessel');

        // Return a JSON response containing the paginated data and pagination meta
        return $this->sendResponse([
            'data' => $aisDataPositions->toArray(), // Paginated data
            'pagination' => [
                'total' => $allAisDataPositions->count(), // Total number of records
                'per_page' => $perPage, // Records per page
                'current_page' => $request->get('skip', 0) / $perPage + 1, // Current page number
                'last_page' => ceil($allAisDataPositions->count() / $perPage), // Last page number
            ],
        ], 'Ais Data Positions retrieved successfully');
    }

    /**
     * Store a newly created AisDataPosition in storage.
     * POST /ais-data-positions
     */
    public function store(CreateAisDataPositionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $aisDataPosition = $this->aisDataPositionRepository->create($input);

        return $this->sendResponse($aisDataPosition->toArray(), 'Ais Data Position saved successfully');
    }

    /**
     * Display the specified AisDataPosition.
     * GET|HEAD /ais-data-positions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var AisDataPosition $aisDataPosition */
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            return $this->sendError('Ais Data Position not found');
        }

        return $this->sendResponse($aisDataPosition->toArray(), 'Ais Data Position retrieved successfully');
    }

    /**
     * Update the specified AisDataPosition in storage.
     * PUT/PATCH /ais-data-positions/{id}
     */
    public function update($id, UpdateAisDataPositionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var AisDataPosition $aisDataPosition */
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            return $this->sendError('Ais Data Position not found');
        }

        $aisDataPosition = $this->aisDataPositionRepository->update($input, $id);

        return $this->sendResponse($aisDataPosition->toArray(), 'AisDataPosition updated successfully');
    }

    /**
     * Remove the specified AisDataPosition from storage.
     * DELETE /ais-data-positions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var AisDataPosition $aisDataPosition */
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            return $this->sendError('Ais Data Position not found');
        }

        $aisDataPosition->delete();

        return $this->sendSuccess('Ais Data Position deleted successfully');
    }
}