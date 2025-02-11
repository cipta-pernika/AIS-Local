<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLocationAPIRequest;
use App\Http\Requests\API\UpdateLocationAPIRequest;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class LocationAPIController
 */
class LocationAPIController extends AppBaseController
{
    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    /**
     * Display a listing of the Locations.
     * GET|HEAD /locations
     */
    public function index(Request $request): JsonResponse
    {
        $query = Location::query();

        // Assuming Location model has a relationship with Geofence model named 'geofence'
        $query->with('geofences', 'locationType')
            ->where($request->except(['skip', 'limit']))
            ->when($request->has('skip'), function ($query) use ($request) {
                return $query->skip($request->get('skip'));
            })
            ->when($request->has('limit'), function ($query) use ($request) {
                return $query->limit($request->get('limit'));
            });

        $locations = $query->get();

        return response()->json([
            'data' => $locations,
            'message' => 'Locations retrieved successfully'
        ]);
    }

    /**
     * Store a newly created Location in storage.
     * POST /locations
     */
    public function store(CreateLocationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $location = $this->locationRepository->create($input);

        return $this->sendResponse($location->toArray(), 'Location saved successfully');
    }

    /**
     * Display the specified Location.
     * GET|HEAD /locations/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Location $location */
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        return $this->sendResponse($location->toArray(), 'Location retrieved successfully');
    }

    /**
     * Update the specified Location in storage.
     * PUT/PATCH /locations/{id}
     */
    public function update($id, UpdateLocationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Location $location */
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        $location = $this->locationRepository->update($input, $id);

        return $this->sendResponse($location->toArray(), 'Location updated successfully');
    }

    /**
     * Remove the specified Location from storage.
     * DELETE /locations/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Location $location */
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        $location->delete();

        return $this->sendSuccess('Location deleted successfully');
    }
}
