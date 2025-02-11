<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePanduTidakTerjadwalRequest;
use App\Http\Requests\UpdatePanduTidakTerjadwalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PanduTidakTerjadwalRepository;
use Illuminate\Http\Request;
use Flash;

class PanduTidakTerjadwalController extends AppBaseController
{
    /** @var PanduTidakTerjadwalRepository $panduTidakTerjadwalRepository*/
    private $panduTidakTerjadwalRepository;

    public function __construct(PanduTidakTerjadwalRepository $panduTidakTerjadwalRepo)
    {
        $this->panduTidakTerjadwalRepository = $panduTidakTerjadwalRepo;
    }

    /**
     * Display a listing of the PanduTidakTerjadwal.
     */
    public function index(Request $request)
    {
        $panduTidakTerjadwals = $this->panduTidakTerjadwalRepository->paginate(10);

        return view('pandu_tidak_terjadwals.index')
            ->with('panduTidakTerjadwals', $panduTidakTerjadwals);
    }

    /**
     * Show the form for creating a new PanduTidakTerjadwal.
     */
    public function create()
    {
        return view('pandu_tidak_terjadwals.create');
    }

    /**
     * Store a newly created PanduTidakTerjadwal in storage.
     */
    public function store(CreatePanduTidakTerjadwalRequest $request)
    {
        $input = $request->all();

        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->create($input);

        Flash::success('Pandu Tidak Terjadwal saved successfully.');

        return redirect(route('panduTidakTerjadwals.index'));
    }

    /**
     * Display the specified PanduTidakTerjadwal.
     */
    public function show($id)
    {
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            Flash::error('Pandu Tidak Terjadwal not found');

            return redirect(route('panduTidakTerjadwals.index'));
        }

        return view('pandu_tidak_terjadwals.show')->with('panduTidakTerjadwal', $panduTidakTerjadwal);
    }

    /**
     * Show the form for editing the specified PanduTidakTerjadwal.
     */
    public function edit($id)
    {
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            Flash::error('Pandu Tidak Terjadwal not found');

            return redirect(route('panduTidakTerjadwals.index'));
        }

        return view('pandu_tidak_terjadwals.edit')->with('panduTidakTerjadwal', $panduTidakTerjadwal);
    }

    /**
     * Update the specified PanduTidakTerjadwal in storage.
     */
    public function update($id, UpdatePanduTidakTerjadwalRequest $request)
    {
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            Flash::error('Pandu Tidak Terjadwal not found');

            return redirect(route('panduTidakTerjadwals.index'));
        }

        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->update($request->all(), $id);

        Flash::success('Pandu Tidak Terjadwal updated successfully.');

        return redirect(route('panduTidakTerjadwals.index'));
    }

    /**
     * Remove the specified PanduTidakTerjadwal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            Flash::error('Pandu Tidak Terjadwal not found');

            return redirect(route('panduTidakTerjadwals.index'));
        }

        $this->panduTidakTerjadwalRepository->delete($id);

        Flash::success('Pandu Tidak Terjadwal deleted successfully.');

        return redirect(route('panduTidakTerjadwals.index'));
    }
}
