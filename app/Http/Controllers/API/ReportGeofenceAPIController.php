<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReportGeofenceAPIRequest;
use App\Http\Requests\API\UpdateReportGeofenceAPIRequest;
use App\Models\ReportGeofence;
use App\Repositories\ReportGeofenceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ReportGeofenceAPIController
 */
class ReportGeofenceAPIController extends AppBaseController
{
    private ReportGeofenceRepository $reportGeofenceRepository;

    public function __construct(ReportGeofenceRepository $reportGeofenceRepo)
    {
        $this->reportGeofenceRepository = $reportGeofenceRepo;
    }

    /**
     * Display a listing of the ReportGeofences.
     * GET|HEAD /report-geofences
     */
    public function index(Request $request): JsonResponse
    {
        $reportGeofences = $this->reportGeofenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($reportGeofences->toArray(), 'Report Geofences retrieved successfully');
    }

    /**
     * Store a newly created ReportGeofence in storage.
     * POST /report-geofences
     */
    public function store(CreateReportGeofenceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $reportGeofence = $this->reportGeofenceRepository->create($input);

        return $this->sendResponse($reportGeofence->toArray(), 'Report Geofence saved successfully');
    }

    /**
     * Display the specified ReportGeofence.
     * GET|HEAD /report-geofences/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ReportGeofence $reportGeofence */
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            return $this->sendError('Report Geofence not found');
        }

        return $this->sendResponse($reportGeofence->toArray(), 'Report Geofence retrieved successfully');
    }

    /**
     * Update the specified ReportGeofence in storage.
     * PUT/PATCH /report-geofences/{id}
     */
    public function update($id, UpdateReportGeofenceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ReportGeofence $reportGeofence */
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            return $this->sendError('Report Geofence not found');
        }

        $reportGeofence = $this->reportGeofenceRepository->update($input, $id);

        return $this->sendResponse($reportGeofence->toArray(), 'ReportGeofence updated successfully');
    }

    /**
     * Remove the specified ReportGeofence from storage.
     * DELETE /report-geofences/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ReportGeofence $reportGeofence */
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            return $this->sendError('Report Geofence not found');
        }

        $reportGeofence->delete();

        return $this->sendSuccess('Report Geofence deleted successfully');
    }
}
