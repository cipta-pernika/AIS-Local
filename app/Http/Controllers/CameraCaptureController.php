<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCameraCaptureRequest;
use App\Http\Requests\UpdateCameraCaptureRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CameraCaptureRepository;
use Illuminate\Http\Request;
use Flash;

class CameraCaptureController extends AppBaseController
{
    /** @var CameraCaptureRepository $cameraCaptureRepository*/
    private $cameraCaptureRepository;

    public function __construct(CameraCaptureRepository $cameraCaptureRepo)
    {
        $this->cameraCaptureRepository = $cameraCaptureRepo;
    }

    /**
     * Display a listing of the CameraCapture.
     */
    public function index(Request $request)
    {
        $cameraCaptures = $this->cameraCaptureRepository->paginate(10);

        return view('camera_captures.index')
            ->with('cameraCaptures', $cameraCaptures);
    }

    /**
     * Show the form for creating a new CameraCapture.
     */
    public function create()
    {
        return view('camera_captures.create');
    }

    /**
     * Store a newly created CameraCapture in storage.
     */
    public function store(CreateCameraCaptureRequest $request)
    {
        $input = $request->all();

        $cameraCapture = $this->cameraCaptureRepository->create($input);

        Flash::success('Camera Capture saved successfully.');

        return redirect(route('cameraCaptures.index'));
    }

    /**
     * Display the specified CameraCapture.
     */
    public function show($id)
    {
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            Flash::error('Camera Capture not found');

            return redirect(route('cameraCaptures.index'));
        }

        return view('camera_captures.show')->with('cameraCapture', $cameraCapture);
    }

    /**
     * Show the form for editing the specified CameraCapture.
     */
    public function edit($id)
    {
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            Flash::error('Camera Capture not found');

            return redirect(route('cameraCaptures.index'));
        }

        return view('camera_captures.edit')->with('cameraCapture', $cameraCapture);
    }

    /**
     * Update the specified CameraCapture in storage.
     */
    public function update($id, UpdateCameraCaptureRequest $request)
    {
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            Flash::error('Camera Capture not found');

            return redirect(route('cameraCaptures.index'));
        }

        $cameraCapture = $this->cameraCaptureRepository->update($request->all(), $id);

        Flash::success('Camera Capture updated successfully.');

        return redirect(route('cameraCaptures.index'));
    }

    /**
     * Remove the specified CameraCapture from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            Flash::error('Camera Capture not found');

            return redirect(route('cameraCaptures.index'));
        }

        $this->cameraCaptureRepository->delete($id);

        Flash::success('Camera Capture deleted successfully.');

        return redirect(route('cameraCaptures.index'));
    }
}
