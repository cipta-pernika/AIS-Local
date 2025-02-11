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
        $perPage = $request->get('per_page', 15);
        $limit = $request->get('limit', $perPage);
        $page = $request->get('page', 1);
        $vessels = $request->get('vessels', []);
        $vessel_name = $request->get('vessel_name');
        $mmsi = $request->get('mmsi');
        
        if (count($vessels) > 1) {
            $aisDataPositions = $this->aisDataPositionRepository->paginate($limit, ['*'], 'page', $page)
                ->whereIn('vessel_id', $vessels);
        } else {
            $aisDataPositions = $this->aisDataPositionRepository->paginate($limit, ['*'], 'page', $page);
        }

        if ($vessel_name) {
            $aisDataPositions = $aisDataPositions->filter(function ($aisDataPosition) use ($vessel_name) {
                return stripos($aisDataPosition->vessel->vessel_name, $vessel_name) !== false;
            });
        }

        if ($mmsi) {
            $aisDataPositions = $aisDataPositions->filter(function ($aisDataPosition) use ($mmsi) {
                return $aisDataPosition->vessel->mmsi == $mmsi;
            });
        }

        // Load vessel relationship for each item
        $aisDataPositions->each(function ($aisDataPosition) {
            $aisDataPosition->load('vessel');
        });

        return $this->sendResponse($aisDataPositions->toArray(), 'Ais Data Positions retrieved successfully');
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