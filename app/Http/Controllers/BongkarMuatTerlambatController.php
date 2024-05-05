<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBongkarMuatTerlambatRequest;
use App\Http\Requests\UpdateBongkarMuatTerlambatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BongkarMuatTerlambatRepository;
use Illuminate\Http\Request;
use Flash;

class BongkarMuatTerlambatController extends AppBaseController
{
    /** @var BongkarMuatTerlambatRepository $bongkarMuatTerlambatRepository*/
    private $bongkarMuatTerlambatRepository;

    public function __construct(BongkarMuatTerlambatRepository $bongkarMuatTerlambatRepo)
    {
        $this->bongkarMuatTerlambatRepository = $bongkarMuatTerlambatRepo;
    }

    /**
     * Display a listing of the BongkarMuatTerlambat.
     */
    public function index(Request $request)
    {
        $bongkarMuatTerlambats = $this->bongkarMuatTerlambatRepository->paginate(10);

        return view('bongkar_muat_terlambats.index')
            ->with('bongkarMuatTerlambats', $bongkarMuatTerlambats);
    }

    /**
     * Show the form for creating a new BongkarMuatTerlambat.
     */
    public function create()
    {
        return view('bongkar_muat_terlambats.create');
    }

    /**
     * Store a newly created BongkarMuatTerlambat in storage.
     */
    public function store(CreateBongkarMuatTerlambatRequest $request)
    {
        $input = $request->all();

        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->create($input);

        Flash::success('Bongkar Muat Terlambat saved successfully.');

        return redirect(route('bongkarMuatTerlambats.index'));
    }

    /**
     * Display the specified BongkarMuatTerlambat.
     */
    public function show($id)
    {
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            Flash::error('Bongkar Muat Terlambat not found');

            return redirect(route('bongkarMuatTerlambats.index'));
        }

        return view('bongkar_muat_terlambats.show')->with('bongkarMuatTerlambat', $bongkarMuatTerlambat);
    }

    /**
     * Show the form for editing the specified BongkarMuatTerlambat.
     */
    public function edit($id)
    {
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            Flash::error('Bongkar Muat Terlambat not found');

            return redirect(route('bongkarMuatTerlambats.index'));
        }

        return view('bongkar_muat_terlambats.edit')->with('bongkarMuatTerlambat', $bongkarMuatTerlambat);
    }

    /**
     * Update the specified BongkarMuatTerlambat in storage.
     */
    public function update($id, UpdateBongkarMuatTerlambatRequest $request)
    {
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            Flash::error('Bongkar Muat Terlambat not found');

            return redirect(route('bongkarMuatTerlambats.index'));
        }

        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->update($request->all(), $id);

        Flash::success('Bongkar Muat Terlambat updated successfully.');

        return redirect(route('bongkarMuatTerlambats.index'));
    }

    /**
     * Remove the specified BongkarMuatTerlambat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            Flash::error('Bongkar Muat Terlambat not found');

            return redirect(route('bongkarMuatTerlambats.index'));
        }

        $this->bongkarMuatTerlambatRepository->delete($id);

        Flash::success('Bongkar Muat Terlambat deleted successfully.');

        return redirect(route('bongkarMuatTerlambats.index'));
    }
}
