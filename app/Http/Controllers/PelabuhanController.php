<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePelabuhanRequest;
use App\Http\Requests\UpdatePelabuhanRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PelabuhanRepository;
use Illuminate\Http\Request;
use Flash;

class PelabuhanController extends AppBaseController
{
    /** @var PelabuhanRepository $pelabuhanRepository*/
    private $pelabuhanRepository;

    public function __construct(PelabuhanRepository $pelabuhanRepo)
    {
        $this->pelabuhanRepository = $pelabuhanRepo;
    }

    /**
     * Display a listing of the Pelabuhan.
     */
    public function index(Request $request)
    {
        $pelabuhans = $this->pelabuhanRepository->paginate(10);

        return view('pelabuhans.index')
            ->with('pelabuhans', $pelabuhans);
    }

    /**
     * Show the form for creating a new Pelabuhan.
     */
    public function create()
    {
        return view('pelabuhans.create');
    }

    /**
     * Store a newly created Pelabuhan in storage.
     */
    public function store(CreatePelabuhanRequest $request)
    {
        $input = $request->all();

        $pelabuhan = $this->pelabuhanRepository->create($input);

        Flash::success('Pelabuhan saved successfully.');

        return redirect(route('pelabuhans.index'));
    }

    /**
     * Display the specified Pelabuhan.
     */
    public function show($id)
    {
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            Flash::error('Pelabuhan not found');

            return redirect(route('pelabuhans.index'));
        }

        return view('pelabuhans.show')->with('pelabuhan', $pelabuhan);
    }

    /**
     * Show the form for editing the specified Pelabuhan.
     */
    public function edit($id)
    {
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            Flash::error('Pelabuhan not found');

            return redirect(route('pelabuhans.index'));
        }

        return view('pelabuhans.edit')->with('pelabuhan', $pelabuhan);
    }

    /**
     * Update the specified Pelabuhan in storage.
     */
    public function update($id, UpdatePelabuhanRequest $request)
    {
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            Flash::error('Pelabuhan not found');

            return redirect(route('pelabuhans.index'));
        }

        $pelabuhan = $this->pelabuhanRepository->update($request->all(), $id);

        Flash::success('Pelabuhan updated successfully.');

        return redirect(route('pelabuhans.index'));
    }

    /**
     * Remove the specified Pelabuhan from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            Flash::error('Pelabuhan not found');

            return redirect(route('pelabuhans.index'));
        }

        $this->pelabuhanRepository->delete($id);

        Flash::success('Pelabuhan deleted successfully.');

        return redirect(route('pelabuhans.index'));
    }
}
