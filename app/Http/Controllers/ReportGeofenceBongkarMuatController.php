<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportGeofenceBongkarMuatRequest;
use App\Http\Requests\UpdateReportGeofenceBongkarMuatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportGeofenceBongkarMuatRepository;
use Illuminate\Http\Request;
use Flash;

class ReportGeofenceBongkarMuatController extends AppBaseController
{
    /** @var ReportGeofenceBongkarMuatRepository $reportGeofenceBongkarMuatRepository*/
    private $reportGeofenceBongkarMuatRepository;

    public function __construct(ReportGeofenceBongkarMuatRepository $reportGeofenceBongkarMuatRepo)
    {
        $this->reportGeofenceBongkarMuatRepository = $reportGeofenceBongkarMuatRepo;
    }

    /**
     * Display a listing of the ReportGeofenceBongkarMuat.
     */
    public function index(Request $request)
    {
        $reportGeofenceBongkarMuats = $this->reportGeofenceBongkarMuatRepository->paginate(10);

        return view('report_geofence_bongkar_muats.index')
            ->with('reportGeofenceBongkarMuats', $reportGeofenceBongkarMuats);
    }

    /**
     * Show the form for creating a new ReportGeofenceBongkarMuat.
     */
    public function create()
    {
        return view('report_geofence_bongkar_muats.create');
    }

    /**
     * Store a newly created ReportGeofenceBongkarMuat in storage.
     */
    public function store(CreateReportGeofenceBongkarMuatRequest $request)
    {
        $input = $request->all();

        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->create($input);

        Flash::success('Report Geofence Bongkar Muat saved successfully.');

        return redirect(route('reportGeofenceBongkarMuats.index'));
    }

    /**
     * Display the specified ReportGeofenceBongkarMuat.
     */
    public function show($id)
    {
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            Flash::error('Report Geofence Bongkar Muat not found');

            return redirect(route('reportGeofenceBongkarMuats.index'));
        }

        return view('report_geofence_bongkar_muats.show')->with('reportGeofenceBongkarMuat', $reportGeofenceBongkarMuat);
    }

    /**
     * Show the form for editing the specified ReportGeofenceBongkarMuat.
     */
    public function edit($id)
    {
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            Flash::error('Report Geofence Bongkar Muat not found');

            return redirect(route('reportGeofenceBongkarMuats.index'));
        }

        return view('report_geofence_bongkar_muats.edit')->with('reportGeofenceBongkarMuat', $reportGeofenceBongkarMuat);
    }

    /**
     * Update the specified ReportGeofenceBongkarMuat in storage.
     */
    public function update($id, UpdateReportGeofenceBongkarMuatRequest $request)
    {
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            Flash::error('Report Geofence Bongkar Muat not found');

            return redirect(route('reportGeofenceBongkarMuats.index'));
        }

        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->update($request->all(), $id);

        Flash::success('Report Geofence Bongkar Muat updated successfully.');

        return redirect(route('reportGeofenceBongkarMuats.index'));
    }

    /**
     * Remove the specified ReportGeofenceBongkarMuat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reportGeofenceBongkarMuat = $this->reportGeofenceBongkarMuatRepository->find($id);

        if (empty($reportGeofenceBongkarMuat)) {
            Flash::error('Report Geofence Bongkar Muat not found');

            return redirect(route('reportGeofenceBongkarMuats.index'));
        }

        $this->reportGeofenceBongkarMuatRepository->delete($id);

        Flash::success('Report Geofence Bongkar Muat deleted successfully.');

        return redirect(route('reportGeofenceBongkarMuats.index'));
    }
}
