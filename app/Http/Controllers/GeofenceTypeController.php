<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGeofenceTypeRequest;
use App\Http\Requests\UpdateGeofenceTypeRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\GeofenceTypeRepository;
use Illuminate\Http\Request;
use Flash;

class GeofenceTypeController extends AppBaseController
{
    /** @var GeofenceTypeRepository $geofenceTypeRepository*/
    private $geofenceTypeRepository;

    public function __construct(GeofenceTypeRepository $geofenceTypeRepo)
    {
        $this->geofenceTypeRepository = $geofenceTypeRepo;
    }

    /**
     * Display a listing of the GeofenceType.
     */
    public function index(Request $request)
    {
        $geofenceTypes = $this->geofenceTypeRepository->paginate(10);

        return view('geofence_types.index')
            ->with('geofenceTypes', $geofenceTypes);
    }

    /**
     * Show the form for creating a new GeofenceType.
     */
    public function create()
    {
        return view('geofence_types.create');
    }

    /**
     * Store a newly created GeofenceType in storage.
     */
    public function store(CreateGeofenceTypeRequest $request)
    {
        $input = $request->all();

        $geofenceType = $this->geofenceTypeRepository->create($input);

        Flash::success('Geofence Type saved successfully.');

        return redirect(route('geofenceTypes.index'));
    }

    /**
     * Display the specified GeofenceType.
     */
    public function show($id)
    {
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            Flash::error('Geofence Type not found');

            return redirect(route('geofenceTypes.index'));
        }

        return view('geofence_types.show')->with('geofenceType', $geofenceType);
    }

    /**
     * Show the form for editing the specified GeofenceType.
     */
    public function edit($id)
    {
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            Flash::error('Geofence Type not found');

            return redirect(route('geofenceTypes.index'));
        }

        return view('geofence_types.edit')->with('geofenceType', $geofenceType);
    }

    /**
     * Update the specified GeofenceType in storage.
     */
    public function update($id, UpdateGeofenceTypeRequest $request)
    {
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            Flash::error('Geofence Type not found');

            return redirect(route('geofenceTypes.index'));
        }

        $geofenceType = $this->geofenceTypeRepository->update($request->all(), $id);

        Flash::success('Geofence Type updated successfully.');

        return redirect(route('geofenceTypes.index'));
    }

    /**
     * Remove the specified GeofenceType from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $geofenceType = $this->geofenceTypeRepository->find($id);

        if (empty($geofenceType)) {
            Flash::error('Geofence Type not found');

            return redirect(route('geofenceTypes.index'));
        }

        $this->geofenceTypeRepository->delete($id);

        Flash::success('Geofence Type deleted successfully.');

        return redirect(route('geofenceTypes.index'));
    }
}
