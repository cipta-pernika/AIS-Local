<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCameraCaptureAPIRequest;
use App\Http\Requests\API\UpdateCameraCaptureAPIRequest;
use App\Models\CameraCapture;
use App\Repositories\CameraCaptureRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;

/**
 * Class CameraCaptureAPIController
 */
class CameraCaptureAPIController extends AppBaseController
{
    private CameraCaptureRepository $cameraCaptureRepository;

    public function __construct(CameraCaptureRepository $cameraCaptureRepo)
    {
        $this->cameraCaptureRepository = $cameraCaptureRepo;
    }

    /**
     * Display a listing of the CameraCaptures.
     * GET|HEAD /camera-captures
     */
    public function index(Request $request): JsonResponse
    {
        $cameraCaptures = $this->cameraCaptureRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cameraCaptures->toArray(), 'Camera Captures retrieved successfully');
    }

    /**
     * Store a newly created CameraCapture in storage.
     * POST /camera-captures
     */
    public function store(CreateCameraCaptureAPIRequest $request): JsonResponse
    {
        // Validate the request
        $validatedData = $request->validated();

        // Get the image file from the request
        $image = $request->file('image');

        // Store the image in a folder by day
        $folderPath = 'camera_captures/' . Carbon::now()->format('Y/m/d');
        $imagePath = $image->store($folderPath);

        // Create a new CameraCapture instance
        $cameraCapture = new CameraCapture();
        $cameraCapture->pelabuhan_id = $validatedData['pelabuhan_id'];
        $cameraCapture->geofence_id = $validatedData['geofence_id'];
        $cameraCapture->image = $imagePath;
        $cameraCapture->save();

        // Return success response
        return $this->sendResponse($cameraCapture->toArray(), 'Camera Capture saved successfully');
    }

    /**
     * Display the specified CameraCapture.
     * GET|HEAD /camera-captures/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CameraCapture $cameraCapture */
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            return $this->sendError('Camera Capture not found');
        }

        return $this->sendResponse($cameraCapture->toArray(), 'Camera Capture retrieved successfully');
    }

    /**
     * Update the specified CameraCapture in storage.
     * PUT/PATCH /camera-captures/{id}
     */
    public function update($id, UpdateCameraCaptureAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CameraCapture $cameraCapture */
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            return $this->sendError('Camera Capture not found');
        }

        $cameraCapture = $this->cameraCaptureRepository->update($input, $id);

        return $this->sendResponse($cameraCapture->toArray(), 'CameraCapture updated successfully');
    }

    /**
     * Remove the specified CameraCapture from storage.
     * DELETE /camera-captures/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CameraCapture $cameraCapture */
        $cameraCapture = $this->cameraCaptureRepository->find($id);

        if (empty($cameraCapture)) {
            return $this->sendError('Camera Capture not found');
        }

        $cameraCapture->delete();

        return $this->sendSuccess('Camera Capture deleted successfully');
    }
}
