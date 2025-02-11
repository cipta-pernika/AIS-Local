<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportGeofencePanduRequest;
use App\Http\Requests\UpdateReportGeofencePanduRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportGeofencePanduRepository;
use Illuminate\Http\Request;
use Flash;

class ReportGeofencePanduController extends AppBaseController
{
    /** @var ReportGeofencePanduRepository $reportGeofencePanduRepository*/
    private $reportGeofencePanduRepository;

    public function __construct(ReportGeofencePanduRepository $reportGeofencePanduRepo)
    {
        $this->reportGeofencePanduRepository = $reportGeofencePanduRepo;
    }

    /**
     * Display a listing of the ReportGeofencePandu.
     */
    public function index(Request $request)
    {
        $reportGeofencePandus = $this->reportGeofencePanduRepository->paginate(10);

        return view('report_geofence_pandus.index')
            ->with('reportGeofencePandus', $reportGeofencePandus);
    }

    /**
     * Show the form for creating a new ReportGeofencePandu.
     */
    public function create()
    {
        return view('report_geofence_pandus.create');
    }

    /**
     * Store a newly created ReportGeofencePandu in storage.
     */
    public function store(CreateReportGeofencePanduRequest $request)
    {
        $input = $request->all();

        $reportGeofencePandu = $this->reportGeofencePanduRepository->create($input);

        Flash::success('Report Geofence Pandu saved successfully.');

        return redirect(route('reportGeofencePandus.index'));
    }

    /**
     * Display the specified ReportGeofencePandu.
     */
    public function show($id)
    {
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            Flash::error('Report Geofence Pandu not found');

            return redirect(route('reportGeofencePandus.index'));
        }

        return view('report_geofence_pandus.show')->with('reportGeofencePandu', $reportGeofencePandu);
    }

    /**
     * Show the form for editing the specified ReportGeofencePandu.
     */
    public function edit($id)
    {
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            Flash::error('Report Geofence Pandu not found');

            return redirect(route('reportGeofencePandus.index'));
        }

        return view('report_geofence_pandus.edit')->with('reportGeofencePandu', $reportGeofencePandu);
    }

    /**
     * Update the specified ReportGeofencePandu in storage.
     */
    public function update($id, UpdateReportGeofencePanduRequest $request)
    {
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            Flash::error('Report Geofence Pandu not found');

            return redirect(route('reportGeofencePandus.index'));
        }

        $reportGeofencePandu = $this->reportGeofencePanduRepository->update($request->all(), $id);

        Flash::success('Report Geofence Pandu updated successfully.');

        return redirect(route('reportGeofencePandus.index'));
    }

    /**
     * Remove the specified ReportGeofencePandu from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reportGeofencePandu = $this->reportGeofencePanduRepository->find($id);

        if (empty($reportGeofencePandu)) {
            Flash::error('Report Geofence Pandu not found');

            return redirect(route('reportGeofencePandus.index'));
        }

        $this->reportGeofencePanduRepository->delete($id);

        Flash::success('Report Geofence Pandu deleted successfully.');

        return redirect(route('reportGeofencePandus.index'));
    }
}
