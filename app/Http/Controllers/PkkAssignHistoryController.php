<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePkkAssignHistoryRequest;
use App\Http\Requests\UpdatePkkAssignHistoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PkkAssignHistoryRepository;
use Illuminate\Http\Request;
use Flash;

class PkkAssignHistoryController extends AppBaseController
{
    /** @var PkkAssignHistoryRepository $pkkAssignHistoryRepository*/
    private $pkkAssignHistoryRepository;

    public function __construct(PkkAssignHistoryRepository $pkkAssignHistoryRepo)
    {
        $this->pkkAssignHistoryRepository = $pkkAssignHistoryRepo;
    }

    /**
     * Display a listing of the PkkAssignHistory.
     */
    public function index(Request $request)
    {
        $pkkAssignHistories = $this->pkkAssignHistoryRepository->paginate(10);

        return view('pkk_assign_histories.index')
            ->with('pkkAssignHistories', $pkkAssignHistories);
    }

    /**
     * Show the form for creating a new PkkAssignHistory.
     */
    public function create()
    {
        return view('pkk_assign_histories.create');
    }

    /**
     * Store a newly created PkkAssignHistory in storage.
     */
    public function store(CreatePkkAssignHistoryRequest $request)
    {
        $input = $request->all();

        $pkkAssignHistory = $this->pkkAssignHistoryRepository->create($input);

        Flash::success('Pkk Assign History saved successfully.');

        return redirect(route('pkkAssignHistories.index'));
    }

    /**
     * Display the specified PkkAssignHistory.
     */
    public function show($id)
    {
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            Flash::error('Pkk Assign History not found');

            return redirect(route('pkkAssignHistories.index'));
        }

        return view('pkk_assign_histories.show')->with('pkkAssignHistory', $pkkAssignHistory);
    }

    /**
     * Show the form for editing the specified PkkAssignHistory.
     */
    public function edit($id)
    {
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            Flash::error('Pkk Assign History not found');

            return redirect(route('pkkAssignHistories.index'));
        }

        return view('pkk_assign_histories.edit')->with('pkkAssignHistory', $pkkAssignHistory);
    }

    /**
     * Update the specified PkkAssignHistory in storage.
     */
    public function update($id, UpdatePkkAssignHistoryRequest $request)
    {
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            Flash::error('Pkk Assign History not found');

            return redirect(route('pkkAssignHistories.index'));
        }

        $pkkAssignHistory = $this->pkkAssignHistoryRepository->update($request->all(), $id);

        Flash::success('Pkk Assign History updated successfully.');

        return redirect(route('pkkAssignHistories.index'));
    }

    /**
     * Remove the specified PkkAssignHistory from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pkkAssignHistory = $this->pkkAssignHistoryRepository->find($id);

        if (empty($pkkAssignHistory)) {
            Flash::error('Pkk Assign History not found');

            return redirect(route('pkkAssignHistories.index'));
        }

        $this->pkkAssignHistoryRepository->delete($id);

        Flash::success('Pkk Assign History deleted successfully.');

        return redirect(route('pkkAssignHistories.index'));
    }
}
