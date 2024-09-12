<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAisDataAnomalyRequest;
use App\Http\Requests\UpdateAisDataAnomalyRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AisDataAnomalyRepository;
use Illuminate\Http\Request;
use Flash;

class AisDataAnomalyController extends AppBaseController
{
    /** @var AisDataAnomalyRepository $aisDataAnomalyRepository*/
    private $aisDataAnomalyRepository;

    public function __construct(AisDataAnomalyRepository $aisDataAnomalyRepo)
    {
        $this->aisDataAnomalyRepository = $aisDataAnomalyRepo;
    }

    /**
     * Display a listing of the AisDataAnomaly.
     */
    public function index(Request $request)
    {
        $aisDataAnomalies = $this->aisDataAnomalyRepository->paginate(10);

        return view('ais_data_anomalies.index')
            ->with('aisDataAnomalies', $aisDataAnomalies);
    }

    /**
     * Show the form for creating a new AisDataAnomaly.
     */
    public function create()
    {
        return view('ais_data_anomalies.create');
    }

    /**
     * Store a newly created AisDataAnomaly in storage.
     */
    public function store(CreateAisDataAnomalyRequest $request)
    {
        $input = $request->all();

        $aisDataAnomaly = $this->aisDataAnomalyRepository->create($input);

        Flash::success('Ais Data Anomaly saved successfully.');

        return redirect(route('aisDataAnomalies.index'));
    }

    /**
     * Display the specified AisDataAnomaly.
     */
    public function show($id)
    {
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            Flash::error('Ais Data Anomaly not found');

            return redirect(route('aisDataAnomalies.index'));
        }

        return view('ais_data_anomalies.show')->with('aisDataAnomaly', $aisDataAnomaly);
    }

    /**
     * Show the form for editing the specified AisDataAnomaly.
     */
    public function edit($id)
    {
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            Flash::error('Ais Data Anomaly not found');

            return redirect(route('aisDataAnomalies.index'));
        }

        return view('ais_data_anomalies.edit')->with('aisDataAnomaly', $aisDataAnomaly);
    }

    /**
     * Update the specified AisDataAnomaly in storage.
     */
    public function update($id, UpdateAisDataAnomalyRequest $request)
    {
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            Flash::error('Ais Data Anomaly not found');

            return redirect(route('aisDataAnomalies.index'));
        }

        $aisDataAnomaly = $this->aisDataAnomalyRepository->update($request->all(), $id);

        Flash::success('Ais Data Anomaly updated successfully.');

        return redirect(route('aisDataAnomalies.index'));
    }

    /**
     * Remove the specified AisDataAnomaly from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $aisDataAnomaly = $this->aisDataAnomalyRepository->find($id);

        if (empty($aisDataAnomaly)) {
            Flash::error('Ais Data Anomaly not found');

            return redirect(route('aisDataAnomalies.index'));
        }

        $this->aisDataAnomalyRepository->delete($id);

        Flash::success('Ais Data Anomaly deleted successfully.');

        return redirect(route('aisDataAnomalies.index'));
    }
}
