<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGeofenceImageAPIRequest;
use App\Http\Requests\API\UpdateGeofenceImageAPIRequest;
use App\Models\GeofenceImage;
use App\Repositories\GeofenceImageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class GeofenceImageAPIController
 */
class GeofenceImageAPIController extends AppBaseController
{
    private GeofenceImageRepository $geofenceImageRepository;

    public function __construct(GeofenceImageRepository $geofenceImageRepo)
    {
        $this->geofenceImageRepository = $geofenceImageRepo;
    }

    /**
     * Display a listing of the GeofenceImages.
     * GET|HEAD /geofence-images
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $limit = $request->get('limit', $perPage);
        $page = $request->get('page', 1);

        $geofenceImages = $this->geofenceImageRepository->all()->sortByDesc('created_at');

        $paginatedGeofenceImages = $geofenceImages->forPage($page, $limit);

        $paginatedGeofenceImages->load(['geofence', 'reportGeofence']);

        return $this->sendResponse($paginatedGeofenceImages->toArray(), 'Geofence Images retrieved successfully');
    }

    /**
     * Store a newly created GeofenceImage in storage.
     * POST /geofence-images
     */
    public function store(CreateGeofenceImageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $geofenceImage = $this->geofenceImageRepository->create($input);

        return $this->sendResponse($geofenceImage->toArray(), 'Geofence Image saved successfully');
    }

    /**
     * Display the specified GeofenceImage.
     * GET|HEAD /geofence-images/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var GeofenceImage $geofenceImage */
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            return $this->sendError('Geofence Image not found');
        }

        return $this->sendResponse($geofenceImage->toArray(), 'Geofence Image retrieved successfully');
    }

    /**
     * Update the specified GeofenceImage in storage.
     * PUT/PATCH /geofence-images/{id}
     */
    public function update($id, UpdateGeofenceImageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var GeofenceImage $geofenceImage */
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            return $this->sendError('Geofence Image not found');
        }

        $geofenceImage = $this->geofenceImageRepository->update($input, $id);

        return $this->sendResponse($geofenceImage->toArray(), 'GeofenceImage updated successfully');
    }

    /**
     * Remove the specified GeofenceImage from storage.
     * DELETE /geofence-images/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var GeofenceImage $geofenceImage */
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            return $this->sendError('Geofence Image not found');
        }

        $geofenceImage->delete();

        return $this->sendSuccess('Geofence Image deleted successfully');
    }
}
