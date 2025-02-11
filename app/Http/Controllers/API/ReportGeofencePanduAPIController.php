<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReportGeofencePanduAPIRequest;
use App\Http\Requests\API\UpdateReportGeofencePanduAPIRequest;
use App\Models\ReportGeofencePandu;
use App\Repositories\ReportGeofencePanduRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ReportGeofencePanduAPIController
 */
class ReportGeofencePanduAPIController extends AppBaseController
{
    private ReportGeofencePanduRepository $reportGeofencePanduRepository;

    public function __construct(ReportGeofencePanduRepository $reportGeofencePanduRepo)
    {
        $this->reportGeofencePanduRepository = $reportGeofencePanduRepo;
    }

    /**
     * Display a listing of the ReportGeofencePandus.
     * GET|HEAD /report-geofence-pandus
     */
    public function index(Request $request): JsonResponse
    {
        $reportGeofencePandus = $this->reportGeofencePanduRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($reportGeofencePandus->toArray(), 'Report Geofence Pandus retrieved successfully');
    }

    /**
     * Store a newly created ReportGeofencePandu in storage.
     * POST /report-geofence-pandus
     */
    public function store(CreateReportGeofencePanduAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $reportGeofencePandu = $this->reportGeofencePanduRepository->create($input);

        return $this->sendResponse($reportGeofencePandu->toArray(), 'Report Geofence Pandu saved successfully');
    }

    /**
     * Display the specified ReportGeofencePandu.
     * GET|HEAD /report-geofence-pandus/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ReportGeofencePandu $reportGeofencePandu */
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            return $this->sendError('Report Geofence Pandu not found');
        }

        return $this->sendResponse($reportGeofencePandu->toArray(), 'Report Geofence Pandu retrieved successfully');
    }

    /**
     * Update the specified ReportGeofencePandu in storage.
     * PUT/PATCH /report-geofence-pandus/{id}
     */
    public function update($id, UpdateReportGeofencePanduAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ReportGeofencePandu $reportGeofencePandu */
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            return $this->sendError('Report Geofence Pandu not found');
        }

        $reportGeofencePandu = $this->reportGeofencePanduRepository->update($input, $id);

        return $this->sendResponse($reportGeofencePandu->toArray(), 'ReportGeofencePandu updated successfully');
    }

    /**
     * Remove the specified ReportGeofencePandu from storage.
     * DELETE /report-geofence-pandus/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ReportGeofencePandu $reportGeofencePandu */
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            return $this->sendError('Report Geofence Pandu not found');
        }

        $reportGeofencePandu->delete();

        return $this->sendSuccess('Report Geofence Pandu deleted successfully');
    }
}
