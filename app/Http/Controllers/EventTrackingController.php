<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventTrackingRequest;
use App\Http\Requests\UpdateEventTrackingRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\EventTrackingRepository;
use Illuminate\Http\Request;
use Flash;

class EventTrackingController extends AppBaseController
{
    /** @var EventTrackingRepository $eventTrackingRepository*/
    private $eventTrackingRepository;

    public function __construct(EventTrackingRepository $eventTrackingRepo)
    {
        $this->eventTrackingRepository = $eventTrackingRepo;
    }

    /**
     * Display a listing of the EventTracking.
     */
    public function index(Request $request)
    {
        $eventTrackings = $this->eventTrackingRepository->paginate(10);

        return view('event_trackings.index')
            ->with('eventTrackings', $eventTrackings);
    }

    /**
     * Show the form for creating a new EventTracking.
     */
    public function create()
    {
        return view('event_trackings.create');
    }

    /**
     * Store a newly created EventTracking in storage.
     */
    public function store(CreateEventTrackingRequest $request)
    {
        $input = $request->all();

        $eventTracking = $this->eventTrackingRepository->create($input);

        Flash::success('Event Tracking saved successfully.');

        return redirect(route('eventTrackings.index'));
    }

    /**
     * Display the specified EventTracking.
     */
    public function show($id)
    {
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            Flash::error('Event Tracking not found');

            return redirect(route('eventTrackings.index'));
        }

        return view('event_trackings.show')->with('eventTracking', $eventTracking);
    }

    /**
     * Show the form for editing the specified EventTracking.
     */
    public function edit($id)
    {
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            Flash::error('Event Tracking not found');

            return redirect(route('eventTrackings.index'));
        }

        return view('event_trackings.edit')->with('eventTracking', $eventTracking);
    }

    /**
     * Update the specified EventTracking in storage.
     */
    public function update($id, UpdateEventTrackingRequest $request)
    {
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            Flash::error('Event Tracking not found');

            return redirect(route('eventTrackings.index'));
        }

        $eventTracking = $this->eventTrackingRepository->update($request->all(), $id);

        Flash::success('Event Tracking updated successfully.');

        return redirect(route('eventTrackings.index'));
    }

    /**
     * Remove the specified EventTracking from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $eventTracking = $this->eventTrackingRepository->find($id);

        if (empty($eventTracking)) {
            Flash::error('Event Tracking not found');

            return redirect(route('eventTrackings.index'));
        }

        $this->eventTrackingRepository->delete($id);

        Flash::success('Event Tracking deleted successfully.');

        return redirect(route('eventTrackings.index'));
    }
}
