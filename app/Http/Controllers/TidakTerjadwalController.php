<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTidakTerjadwalRequest;
use App\Http\Requests\UpdateTidakTerjadwalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TidakTerjadwalRepository;
use Illuminate\Http\Request;
use Flash;

class TidakTerjadwalController extends AppBaseController
{
    /** @var TidakTerjadwalRepository $tidakTerjadwalRepository*/
    private $tidakTerjadwalRepository;

    public function __construct(TidakTerjadwalRepository $tidakTerjadwalRepo)
    {
        $this->tidakTerjadwalRepository = $tidakTerjadwalRepo;
    }

    /**
     * Display a listing of the TidakTerjadwal.
     */
    public function index(Request $request)
    {
        $tidakTerjadwals = $this->tidakTerjadwalRepository->paginate(10);

        return view('tidak_terjadwals.index')
            ->with('tidakTerjadwals', $tidakTerjadwals);
    }

    /**
     * Show the form for creating a new TidakTerjadwal.
     */
    public function create()
    {
        return view('tidak_terjadwals.create');
    }

    /**
     * Store a newly created TidakTerjadwal in storage.
     */
    public function store(CreateTidakTerjadwalRequest $request)
    {
        $input = $request->all();

        $tidakTerjadwal = $this->tidakTerjadwalRepository->create($input);

        Flash::success('Tidak Terjadwal saved successfully.');

        return redirect(route('tidakTerjadwals.index'));
    }

    /**
     * Display the specified TidakTerjadwal.
     */
    public function show($id)
    {
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            Flash::error('Tidak Terjadwal not found');

            return redirect(route('tidakTerjadwals.index'));
        }

        return view('tidak_terjadwals.show')->with('tidakTerjadwal', $tidakTerjadwal);
    }

    /**
     * Show the form for editing the specified TidakTerjadwal.
     */
    public function edit($id)
    {
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            Flash::error('Tidak Terjadwal not found');

            return redirect(route('tidakTerjadwals.index'));
        }

        return view('tidak_terjadwals.edit')->with('tidakTerjadwal', $tidakTerjadwal);
    }

    /**
     * Update the specified TidakTerjadwal in storage.
     */
    public function update($id, UpdateTidakTerjadwalRequest $request)
    {
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            Flash::error('Tidak Terjadwal not found');

            return redirect(route('tidakTerjadwals.index'));
        }

        $tidakTerjadwal = $this->tidakTerjadwalRepository->update($request->all(), $id);

        Flash::success('Tidak Terjadwal updated successfully.');

        return redirect(route('tidakTerjadwals.index'));
    }

    /**
     * Remove the specified TidakTerjadwal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            Flash::error('Tidak Terjadwal not found');

            return redirect(route('tidakTerjadwals.index'));
        }

        $this->tidakTerjadwalRepository->delete($id);

        Flash::success('Tidak Terjadwal deleted successfully.');

        return redirect(route('tidakTerjadwals.index'));
    }
}
