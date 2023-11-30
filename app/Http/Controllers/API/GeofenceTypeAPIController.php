<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGeofenceTypeAPIRequest;
use App\Http\Requests\API\UpdateGeofenceTypeAPIRequest;
use App\Models\GeofenceType;
use App\Repositories\GeofenceTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class GeofenceTypeAPIController
 */
class GeofenceTypeAPIController extends AppBaseController
{
    private GeofenceTypeRepository $geofenceTypeRepository;

    public function __construct(GeofenceTypeRepository $geofenceTypeRepo)
    {
        $this->geofenceTypeRepository = $geofenceTypeRepo;
    }

    /**
     * Display a listing of the GeofenceTypes.
     * GET|HEAD /geofence-types
     */
    public function index(Request $request): JsonResponse
    {
        $geofenceTypes = $this->geofenceTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($geofenceTypes->toArray(), 'Geofence Types retrieved successfully');
    }

    /**
     * Store a newly created GeofenceType in storage.
     * POST /geofence-types
     */
    public function store(CreateGeofenceTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $geofenceType = $this->geofenceTypeRepository->create($input);

        return $this->sendResponse($geofenceType->toArray(), 'Geofence Type saved successfully');
    }

    /**
     * Display the specified GeofenceType.
     * GET|HEAD /geofence-types/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var GeofenceType $geofenceType */
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            return $this->sendError('Geofence Type not found');
        }

        return $this->sendResponse($geofenceType->toArray(), 'Geofence Type retrieved successfully');
    }

    /**
     * Update the specified GeofenceType in storage.
     * PUT/PATCH /geofence-types/{id}
     */
    public function update($id, UpdateGeofenceTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var GeofenceType $geofenceType */
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            return $this->sendError('Geofence Type not found');
        }

        $geofenceType = $this->geofenceTypeRepository->update($input, $id);

        return $this->sendResponse($geofenceType->toArray(), 'GeofenceType updated successfully');
    }

    /**
     * Remove the specified GeofenceType from storage.
     * DELETE /geofence-types/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var GeofenceType $geofenceType */
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            return $this->sendError('Geofence Type not found');
        }

        $geofenceType->delete();

        return $this->sendSuccess('Geofence Type deleted successfully');
    }
}
