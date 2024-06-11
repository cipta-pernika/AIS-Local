<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEventTrackingAPIRequest;
use App\Http\Requests\API\UpdateEventTrackingAPIRequest;
use App\Models\EventTracking;
use App\Repositories\EventTrackingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class EventTrackingAPIController
 */
class EventTrackingAPIController extends AppBaseController
{
    private EventTrackingRepository $eventTrackingRepository;

    public function __construct(EventTrackingRepository $eventTrackingRepo)
    {
        $this->eventTrackingRepository = $eventTrackingRepo;
    }

    /**
     * Display a listing of the EventTrackings.
     * GET|HEAD /event-trackings
     */
    public function index(Request $request): JsonResponse
    {
        $eventTrackings = $this->eventTrackingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        $eventTrackings->load(['aisDataPosition', 'asset', 'event']);

        return $this->sendResponse($eventTrackings->toArray(), 'Event Trackings retrieved successfully');
    }

    /**
     * Store a newly created EventTracking in storage.
     * POST /event-trackings
     */
    public function store(CreateEventTrackingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $eventTracking = $this->eventTrackingRepository->create($input);

        return $this->sendResponse($eventTracking->toArray(), 'Event Tracking saved successfully');
    }

    /**
     * Display the specified EventTracking.
     * GET|HEAD /event-trackings/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var EventTracking $eventTracking */
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            return $this->sendError('Event Tracking not found');
        }

        return $this->sendResponse($eventTracking->toArray(), 'Event Tracking retrieved successfully');
    }

    /**
     * Update the specified EventTracking in storage.
     * PUT/PATCH /event-trackings/{id}
     */
    public function update($id, UpdateEventTrackingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var EventTracking $eventTracking */
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            return $this->sendError('Event Tracking not found');
        }

        $eventTracking = $this->eventTrackingRepository->update($input, $id);

        return $this->sendResponse($eventTracking->toArray(), 'EventTracking updated successfully');
    }

    /**
     * Remove the specified EventTracking from storage.
     * DELETE /event-trackings/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var EventTracking $eventTracking */
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            return $this->sendError('Event Tracking not found');
        }

        $eventTracking->delete();

        return $this->sendSuccess('Event Tracking deleted successfully');
    }
}
