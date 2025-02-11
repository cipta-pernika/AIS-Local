<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReportGeofenceBongkarMuatAPIRequest;
use App\Http\Requests\API\UpdateReportGeofenceBongkarMuatAPIRequest;
use App\Models\ReportGeofenceBongkarMuat;
use App\Repositories\ReportGeofenceBongkarMuatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ReportGeofenceBongkarMuatAPIController
 */
class ReportGeofenceBongkarMuatAPIController extends AppBaseController
{
    private ReportGeofenceBongkarMuatRepository $reportGeofenceBongkarMuatRepository;

    public function __construct(ReportGeofenceBongkarMuatRepository $reportGeofenceBongkarMuatRepo)
    {
        $this->reportGeofenceBongkarMuatRepository = $reportGeofenceBongkarMuatRepo;
    }

    /**
     * Display a listing of the ReportGeofenceBongkarMuats.
     * GET|HEAD /report-geofence-bongkar-muats
     */
    public function index(Request $request): JsonResponse
    {
        $reportGeofenceBongkarMuats = $this->reportGeofenceBongkarMuatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($reportGeofenceBongkarMuats->toArray(), 'Report Geofence Bongkar Muats retrieved successfully');
    }

    /**
     * Store a newly created ReportGeofenceBongkarMuat in storage.
     * POST /report-geofence-bongkar-muats
     */
    public function store(CreateReportGeofenceBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->create($input);

        return $this->sendResponse($reportGeofenceBongkarMuat->toArray(), 'Report Geofence Bongkar Muat saved successfully');
    }

    /**
     * Display the specified ReportGeofenceBongkarMuat.
     * GET|HEAD /report-geofence-bongkar-muats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ReportGeofenceBongkarMuat $reportGeofenceBongkarMuat */
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            return $this->sendError('Report Geofence Bongkar Muat not found');
        }

        return $this->sendResponse($reportGeofenceBongkarMuat->toArray(), 'Report Geofence Bongkar Muat retrieved successfully');
    }

    /**
     * Update the specified ReportGeofenceBongkarMuat in storage.
     * PUT/PATCH /report-geofence-bongkar-muats/{id}
     */
    public function update($id, UpdateReportGeofenceBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ReportGeofenceBongkarMuat $reportGeofenceBongkarMuat */
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            return $this->sendError('Report Geofence Bongkar Muat not found');
        }

        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->update($input, $id);

        return $this->sendResponse($reportGeofenceBongkarMuat->toArray(), 'ReportGeofenceBongkarMuat updated successfully');
    }

    /**
     * Remove the specified ReportGeofenceBongkarMuat from storage.
     * DELETE /report-geofence-bongkar-muats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ReportGeofenceBongkarMuat $reportGeofenceBongkarMuat */
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            return $this->sendError('Report Geofence Bongkar Muat not found');
        }

        $reportGeofenceBongkarMuat->delete();

        return $this->sendSuccess('Report Geofence Bongkar Muat deleted successfully');
    }
}
