<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePanduTerlambatRequest;
use App\Http\Requests\UpdatePanduTerlambatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PanduTerlambatRepository;
use Illuminate\Http\Request;
use Flash;

class PanduTerlambatController extends AppBaseController
{
    /** @var PanduTerlambatRepository $panduTerlambatRepository*/
    private $panduTerlambatRepository;

    public function __construct(PanduTerlambatRepository $panduTerlambatRepo)
    {
        $this->panduTerlambatRepository = $panduTerlambatRepo;
    }

    /**
     * Display a listing of the PanduTerlambat.
     */
    public function index(Request $request)
    {
        $panduTerlambats = $this->panduTerlambatRepository->paginate(10);

        return view('pandu_terlambats.index')
            ->with('panduTerlambats', $panduTerlambats);
    }

    /**
     * Show the form for creating a new PanduTerlambat.
     */
    public function create()
    {
        return view('pandu_terlambats.create');
    }

    /**
     * Store a newly created PanduTerlambat in storage.
     */
    public function store(CreatePanduTerlambatRequest $request)
    {
        $input = $request->all();

        $panduTerlambat = $this->panduTerlambatRepository->create($input);

        Flash::success('Pandu Terlambat saved successfully.');

        return redirect(route('panduTerlambats.index'));
    }

    /**
     * Display the specified PanduTerlambat.
     */
    public function show($id)
    {
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            Flash::error('Pandu Terlambat not found');

            return redirect(route('panduTerlambats.index'));
        }

        return view('pandu_terlambats.show')->with('panduTerlambat', $panduTerlambat);
    }

    /**
     * Show the form for editing the specified PanduTerlambat.
     */
    public function edit($id)
    {
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            Flash::error('Pandu Terlambat not found');

            return redirect(route('panduTerlambats.index'));
        }

        return view('pandu_terlambats.edit')->with('panduTerlambat', $panduTerlambat);
    }

    /**
     * Update the specified PanduTerlambat in storage.
     */
    public function update($id, UpdatePanduTerlambatRequest $request)
    {
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            Flash::error('Pandu Terlambat not found');

            return redirect(route('panduTerlambats.index'));
        }

        $panduTerlambat = $this->panduTerlambatRepository->update($request->all(), $id);

        Flash::success('Pandu Terlambat updated successfully.');

        return redirect(route('panduTerlambats.index'));
    }

    /**
     * Remove the specified PanduTerlambat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            Flash::error('Pandu Terlambat not found');

            return redirect(route('panduTerlambats.index'));
        }

        $this->panduTerlambatRepository->delete($id);

        Flash::success('Pandu Terlambat deleted successfully.');

        return redirect(route('panduTerlambats.index'));
    }
}
