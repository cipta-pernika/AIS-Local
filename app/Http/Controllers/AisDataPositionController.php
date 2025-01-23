<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAisDataPositionRequest;
use App\Http\Requests\UpdateAisDataPositionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AisDataPositionRepository;
use Illuminate\Http\Request;
use Flash;

class AisDataPositionController extends AppBaseController
{
    /** @var AisDataPositionRepository $aisDataPositionRepository*/
    private $aisDataPositionRepository;

    public function __construct(AisDataPositionRepository $aisDataPositionRepo)
    {
        $this->aisDataPositionRepository = $aisDataPositionRepo;
    }

    /**
     * Display a listing of the AisDataPosition.
     */
    public function index(Request $request)
    {
        $aisDataPositions = $this->aisDataPositionRepository->paginate(10);

        return view('ais_data_positions.index')
            ->with('aisDataPositions', $aisDataPositions);
    }

    /**
     * Show the form for creating a new AisDataPosition.
     */
    public function create()
    {
        return view('ais_data_positions.create');
    }

    /**
     * Store a newly created AisDataPosition in storage.
     */
    public function store(CreateAisDataPositionRequest $request)
    {
        $input = $request->all();

        $aisDataPosition = $this->aisDataPositionRepository->create($input);

        Flash::success('Ais Data Position saved successfully.');

        return redirect(route('aisDataPositions.index'));
    }

    /**
     * Display the specified AisDataPosition.
     */
    public function show($id)
    {
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            Flash::error('Ais Data Position not found');

            return redirect(route('aisDataPositions.index'));
        }

        return view('ais_data_positions.show')->with('aisDataPosition', $aisDataPosition);
    }

    /**
     * Show the form for editing the specified AisDataPosition.
     */
    public function edit($id)
    {
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            Flash::error('Ais Data Position not found');

            return redirect(route('aisDataPositions.index'));
        }

        return view('ais_data_positions.edit')->with('aisDataPosition', $aisDataPosition);
    }

    /**
     * Update the specified AisDataPosition in storage.
     */
    public function update($id, UpdateAisDataPositionRequest $request)
    {
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            Flash::error('Ais Data Position not found');

            return redirect(route('aisDataPositions.index'));
        }

        $aisDataPosition = $this->aisDataPositionRepository->update($request->all(), $id);

        Flash::success('Ais Data Position updated successfully.');

        return redirect(route('aisDataPositions.index'));
    }

    /**
     * Remove the specified AisDataPosition from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $aisDataPosition = $this->aisDataPositionRepository->find($id);

        if (empty($aisDataPosition)) {
            Flash::error('Ais Data Position not found');

            return redirect(route('aisDataPositions.index'));
        }

        $this->aisDataPositionRepository->delete($id);

        Flash::success('Ais Data Position deleted successfully.');

        return redirect(route('aisDataPositions.index'));
    }
}
