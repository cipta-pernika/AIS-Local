<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGeofenceImageRequest;
use App\Http\Requests\UpdateGeofenceImageRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\GeofenceImageRepository;
use Illuminate\Http\Request;
use Flash;

class GeofenceImageController extends AppBaseController
{
    /** @var GeofenceImageRepository $geofenceImageRepository*/
    private $geofenceImageRepository;

    public function __construct(GeofenceImageRepository $geofenceImageRepo)
    {
        $this->geofenceImageRepository = $geofenceImageRepo;
    }

    /**
     * Display a listing of the GeofenceImage.
     */
    public function index(Request $request)
    {
        $geofenceImages = $this->geofenceImageRepository->paginate(10);

        return view('geofence_images.index')
            ->with('geofenceImages', $geofenceImages);
    }

    /**
     * Show the form for creating a new GeofenceImage.
     */
    public function create()
    {
        return view('geofence_images.create');
    }

    /**
     * Store a newly created GeofenceImage in storage.
     */
    public function store(CreateGeofenceImageRequest $request)
    {
        $input = $request->all();

        $geofenceImage = $this->geofenceImageRepository->create($input);

        Flash::success('Geofence Image saved successfully.');

        return redirect(route('geofenceImages.index'));
    }

    /**
     * Display the specified GeofenceImage.
     */
    public function show($id)
    {
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            Flash::error('Geofence Image not found');

            return redirect(route('geofenceImages.index'));
        }

        return view('geofence_images.show')->with('geofenceImage', $geofenceImage);
    }

    /**
     * Show the form for editing the specified GeofenceImage.
     */
    public function edit($id)
    {
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            Flash::error('Geofence Image not found');

            return redirect(route('geofenceImages.index'));
        }

        return view('geofence_images.edit')->with('geofenceImage', $geofenceImage);
    }

    /**
     * Update the specified GeofenceImage in storage.
     */
    public function update($id, UpdateGeofenceImageRequest $request)
    {
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            Flash::error('Geofence Image not found');

            return redirect(route('geofenceImages.index'));
        }

        $geofenceImage = $this->geofenceImageRepository->update($request->all(), $id);

        Flash::success('Geofence Image updated successfully.');

        return redirect(route('geofenceImages.index'));
    }

    /**
     * Remove the specified GeofenceImage from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $geofenceImage = $this->geofenceImageRepository->find($id);

        if (empty($geofenceImage)) {
            Flash::error('Geofence Image not found');

            return redirect(route('geofenceImages.index'));
        }

        $this->geofenceImageRepository->delete($id);

        Flash::success('Geofence Image deleted successfully.');

        return redirect(route('geofenceImages.index'));
    }
}
