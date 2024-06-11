<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrackingRequest;
use App\Http\Requests\UpdateTrackingRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TrackingRepository;
use Illuminate\Http\Request;
use Flash;

class TrackingController extends AppBaseController
{
    /** @var TrackingRepository $trackingRepository*/
    private $trackingRepository;

    public function __construct(TrackingRepository $trackingRepo)
    {
        $this->trackingRepository = $trackingRepo;
    }

    /**
     * Display a listing of the Tracking.
     */
    public function index(Request $request)
    {
        $trackings = $this->trackingRepository->paginate(10);

        return view('trackings.index')
            ->with('trackings', $trackings);
    }

    /**
     * Show the form for creating a new Tracking.
     */
    public function create()
    {
        return view('trackings.create');
    }

    /**
     * Store a newly created Tracking in storage.
     */
    public function store(CreateTrackingRequest $request)
    {
        $input = $request->all();

        $tracking = $this->trackingRepository->create($input);

        Flash::success('Tracking saved successfully.');

        return redirect(route('trackings.index'));
    }

    /**
     * Display the specified Tracking.
     */
    public function show($id)
    {
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            Flash::error('Tracking not found');

            return redirect(route('trackings.index'));
        }

        return view('trackings.show')->with('tracking', $tracking);
    }

    /**
     * Show the form for editing the specified Tracking.
     */
    public function edit($id)
    {
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            Flash::error('Tracking not found');

            return redirect(route('trackings.index'));
        }

        return view('trackings.edit')->with('tracking', $tracking);
    }

    /**
     * Update the specified Tracking in storage.
     */
    public function update($id, UpdateTrackingRequest $request)
    {
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            Flash::error('Tracking not found');

            return redirect(route('trackings.index'));
        }

        $tracking = $this->trackingRepository->update($request->all(), $id);

        Flash::success('Tracking updated successfully.');

        return redirect(route('trackings.index'));
    }

    /**
     * Remove the specified Tracking from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tracking = $this->trackingRepository->find($id);

        if (empty($tracking)) {
            Flash::error('Tracking not found');

            return redirect(route('trackings.index'));
        }

        $this->trackingRepository->delete($id);

        Flash::success('Tracking deleted successfully.');

        return redirect(route('trackings.index'));
    }
}
