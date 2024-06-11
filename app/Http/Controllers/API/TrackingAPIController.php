<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTrackingAPIRequest;
use App\Http\Requests\API\UpdateTrackingAPIRequest;
use App\Models\Tracking;
use App\Repositories\TrackingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TrackingAPIController
 */
class TrackingAPIController extends AppBaseController
{
    private TrackingRepository $trackingRepository;

    public function __construct(TrackingRepository $trackingRepo)
    {
        $this->trackingRepository = $trackingRepo;
    }

    /**
     * Display a listing of the Trackings.
     * GET|HEAD /trackings
     */
    public function index(Request $request): JsonResponse
    {
        $trackings = $this->trackingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($trackings->toArray(), 'Trackings retrieved successfully');
    }

    /**
     * Store a newly created Tracking in storage.
     * POST /trackings
     */
    public function store(CreateTrackingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $tracking = $this->trackingRepository->create($input);

        return $this->sendResponse($tracking->toArray(), 'Tracking saved successfully');
    }

    /**
     * Display the specified Tracking.
     * GET|HEAD /trackings/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Tracking $tracking */
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            return $this->sendError('Tracking not found');
        }

        return $this->sendResponse($tracking->toArray(), 'Tracking retrieved successfully');
    }

    /**
     * Update the specified Tracking in storage.
     * PUT/PATCH /trackings/{id}
     */
    public function update($id, UpdateTrackingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Tracking $tracking */
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            return $this->sendError('Tracking not found');
        }

        $tracking = $this->trackingRepository->update($input, $id);

        return $this->sendResponse($tracking->toArray(), 'Tracking updated successfully');
    }

    /**
     * Remove the specified Tracking from storage.
     * DELETE /trackings/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Tracking $tracking */
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            return $this->sendError('Tracking not found');
        }

        $tracking->delete();

        return $this->sendSuccess('Tracking deleted successfully');
    }
}
