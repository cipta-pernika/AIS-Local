<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePkkHistoryRequest;
use App\Http\Requests\UpdatePkkHistoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PkkHistoryRepository;
use Illuminate\Http\Request;
use Flash;

class PkkHistoryController extends AppBaseController
{
    /** @var PkkHistoryRepository $pkkHistoryRepository*/
    private $pkkHistoryRepository;

    public function __construct(PkkHistoryRepository $pkkHistoryRepo)
    {
        $this->pkkHistoryRepository = $pkkHistoryRepo;
    }

    /**
     * Display a listing of the PkkHistory.
     */
    public function index(Request $request)
    {
        $pkkHistories = $this->pkkHistoryRepository->paginate(10);

        return view('pkk_histories.index')
            ->with('pkkHistories', $pkkHistories);
    }

    /**
     * Show the form for creating a new PkkHistory.
     */
    public function create()
    {
        return view('pkk_histories.create');
    }

    /**
     * Store a newly created PkkHistory in storage.
     */
    public function store(CreatePkkHistoryRequest $request)
    {
        $input = $request->all();

        $pkkHistory = $this->pkkHistoryRepository->create($input);

        Flash::success('Pkk History saved successfully.');

        return redirect(route('pkkHistories.index'));
    }

    /**
     * Display the specified PkkHistory.
     */
    public function show($id)
    {
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            Flash::error('Pkk History not found');

            return redirect(route('pkkHistories.index'));
        }

        return view('pkk_histories.show')->with('pkkHistory', $pkkHistory);
    }

    /**
     * Show the form for editing the specified PkkHistory.
     */
    public function edit($id)
    {
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            Flash::error('Pkk History not found');

            return redirect(route('pkkHistories.index'));
        }

        return view('pkk_histories.edit')->with('pkkHistory', $pkkHistory);
    }

    /**
     * Update the specified PkkHistory in storage.
     */
    public function update($id, UpdatePkkHistoryRequest $request)
    {
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            Flash::error('Pkk History not found');

            return redirect(route('pkkHistories.index'));
        }

        $pkkHistory = $this->pkkHistoryRepository->update($request->all(), $id);

        Flash::success('Pkk History updated successfully.');

        return redirect(route('pkkHistories.index'));
    }

    /**
     * Remove the specified PkkHistory from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pkkHistory = $this->pkkHistoryRepository->find($id);

        if (empty($pkkHistory)) {
            Flash::error('Pkk History not found');

            return redirect(route('pkkHistories.index'));
        }

        $this->pkkHistoryRepository->delete($id);

        Flash::success('Pkk History deleted successfully.');

        return redirect(route('pkkHistories.index'));
    }
}
