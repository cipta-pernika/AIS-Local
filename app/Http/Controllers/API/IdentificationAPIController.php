<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIdentificationAPIRequest;
use App\Http\Requests\API\UpdateIdentificationAPIRequest;
use App\Models\Identification;
use App\Repositories\IdentificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class IdentificationAPIController
 */
class IdentificationAPIController extends AppBaseController
{
    private IdentificationRepository $identificationRepository;

    public function __construct(IdentificationRepository $identificationRepo)
    {
        $this->identificationRepository = $identificationRepo;
    }

    /**
     * Display a listing of the Identifications.
     * GET|HEAD /identifications
     */
    public function index(Request $request): JsonResponse
    {
        $identifications = $this->identificationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($identifications->toArray(), 'Identifications retrieved successfully');
    }

    /**
     * Store a newly created Identification in storage.
     * POST /identifications
     */
    public function store(CreateIdentificationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $identification = $this->identificationRepository->create($input);

        return $this->sendResponse($identification->toArray(), 'Identification saved successfully');
    }

    /**
     * Display the specified Identification.
     * GET|HEAD /identifications/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Identification $identification */
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            return $this->sendError('Identification not found');
        }

        return $this->sendResponse($identification->toArray(), 'Identification retrieved successfully');
    }

    /**
     * Update the specified Identification in storage.
     * PUT/PATCH /identifications/{id}
     */
    public function update($id, UpdateIdentificationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Identification $identification */
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            return $this->sendError('Identification not found');
        }

        $identification = $this->identificationRepository->update($input, $id);

        return $this->sendResponse($identification->toArray(), 'Identification updated successfully');
    }

    /**
     * Remove the specified Identification from storage.
     * DELETE /identifications/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Identification $identification */
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            return $this->sendError('Identification not found');
        }

        $identification->delete();

        return $this->sendSuccess('Identification deleted successfully');
    }
}
