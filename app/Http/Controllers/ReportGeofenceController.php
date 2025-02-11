<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportGeofenceRequest;
use App\Http\Requests\UpdateReportGeofenceRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportGeofenceRepository;
use Illuminate\Http\Request;
use Flash;

class ReportGeofenceController extends AppBaseController
{
    /** @var ReportGeofenceRepository $reportGeofenceRepository*/
    private $reportGeofenceRepository;

    public function __construct(ReportGeofenceRepository $reportGeofenceRepo)
    {
        $this->reportGeofenceRepository = $reportGeofenceRepo;
    }

    /**
     * Display a listing of the ReportGeofence.
     */
    public function index(Request $request)
    {
        $reportGeofences = $this->reportGeofenceRepository->paginate(10);

        return view('report_geofences.index')
            ->with('reportGeofences', $reportGeofences);
    }

    /**
     * Show the form for creating a new ReportGeofence.
     */
    public function create()
    {
        return view('report_geofences.create');
    }

    /**
     * Store a newly created ReportGeofence in storage.
     */
    public function store(CreateReportGeofenceRequest $request)
    {
        $input = $request->all();

        $reportGeofence = $this->reportGeofenceRepository->create($input);

        Flash::success('Report Geofence saved successfully.');

        return redirect(route('reportGeofences.index'));
    }

    /**
     * Display the specified ReportGeofence.
     */
    public function show($id)
    {
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            Flash::error('Report Geofence not found');

            return redirect(route('reportGeofences.index'));
        }

        return view('report_geofences.show')->with('reportGeofence', $reportGeofence);
    }

    /**
     * Show the form for editing the specified ReportGeofence.
     */
    public function edit($id)
    {
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            Flash::error('Report Geofence not found');

            return redirect(route('reportGeofences.index'));
        }

        return view('report_geofences.edit')->with('reportGeofence', $reportGeofence);
    }

    /**
     * Update the specified ReportGeofence in storage.
     */
    public function update($id, UpdateReportGeofenceRequest $request)
    {
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            Flash::error('Report Geofence not found');

            return redirect(route('reportGeofences.index'));
        }

        $reportGeofence = $this->reportGeofenceRepository->update($request->all(), $id);

        Flash::success('Report Geofence updated successfully.');

        return redirect(route('reportGeofences.index'));
    }

    /**
     * Remove the specified ReportGeofence from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reportGeofence = $this->reportGeofenceRepository->find($id);

        if (empty($reportGeofence)) {
            Flash::error('Report Geofence not found');

            return redirect(route('reportGeofences.index'));
        }

        $this->reportGeofenceRepository->delete($id);

        Flash::success('Report Geofence deleted successfully.');

        return redirect(route('reportGeofences.index'));
    }
}
