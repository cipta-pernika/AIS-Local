<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnomalyVariableRequest;
use App\Http\Requests\UpdateAnomalyVariableRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AnomalyVariableRepository;
use Illuminate\Http\Request;
use Flash;

class AnomalyVariableController extends AppBaseController
{
    /** @var AnomalyVariableRepository $anomalyVariableRepository*/
    private $anomalyVariableRepository;

    public function __construct(AnomalyVariableRepository $anomalyVariableRepo)
    {
        $this->anomalyVariableRepository = $anomalyVariableRepo;
    }

    /**
     * Display a listing of the AnomalyVariable.
     */
    public function index(Request $request)
    {
        $anomalyVariables = $this->anomalyVariableRepository->paginate(10);

        return view('anomaly_variables.index')
            ->with('anomalyVariables', $anomalyVariables);
    }

    /**
     * Show the form for creating a new AnomalyVariable.
     */
    public function create()
    {
        return view('anomaly_variables.create');
    }

    /**
     * Store a newly created AnomalyVariable in storage.
     */
    public function store(CreateAnomalyVariableRequest $request)
    {
        $input = $request->all();

        $anomalyVariable = $this->anomalyVariableRepository->create($input);

        Flash::success('Anomaly Variable saved successfully.');

        return redirect(route('anomalyVariables.index'));
    }

    /**
     * Display the specified AnomalyVariable.
     */
    public function show($id)
    {
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            Flash::error('Anomaly Variable not found');

            return redirect(route('anomalyVariables.index'));
        }

        return view('anomaly_variables.show')->with('anomalyVariable', $anomalyVariable);
    }

    /**
     * Show the form for editing the specified AnomalyVariable.
     */
    public function edit($id)
    {
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            Flash::error('Anomaly Variable not found');

            return redirect(route('anomalyVariables.index'));
        }

        return view('anomaly_variables.edit')->with('anomalyVariable', $anomalyVariable);
    }

    /**
     * Update the specified AnomalyVariable in storage.
     */
    public function update($id, UpdateAnomalyVariableRequest $request)
    {
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            Flash::error('Anomaly Variable not found');

            return redirect(route('anomalyVariables.index'));
        }

        $anomalyVariable = $this->anomalyVariableRepository->update($request->all(), $id);

        Flash::success('Anomaly Variable updated successfully.');

        return redirect(route('anomalyVariables.index'));
    }

    /**
     * Remove the specified AnomalyVariable from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $anomalyVariable = $this->anomalyVariableRepository->find($id);

        if (empty($anomalyVariable)) {
            Flash::error('Anomaly Variable not found');

            return redirect(route('anomalyVariables.index'));
        }

        $this->anomalyVariableRepository->delete($id);

        Flash::success('Anomaly Variable deleted successfully.');

        return redirect(route('anomalyVariables.index'));
    }
}
