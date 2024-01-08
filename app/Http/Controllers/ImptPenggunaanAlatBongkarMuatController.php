<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImptPenggunaanAlatBongkarMuatRequest;
use App\Http\Requests\UpdateImptPenggunaanAlatBongkarMuatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ImptPenggunaanAlatBongkarMuatRepository;
use Illuminate\Http\Request;
use Flash;

class ImptPenggunaanAlatBongkarMuatController extends AppBaseController
{
    /** @var ImptPenggunaanAlatBongkarMuatRepository $imptPenggunaanAlatBongkarMuatRepository*/
    private $imptPenggunaanAlatBongkarMuatRepository;

    public function __construct(ImptPenggunaanAlatBongkarMuatRepository $imptPenggunaanAlatBongkarMuatRepo)
    {
        $this->imptPenggunaanAlatBongkarMuatRepository = $imptPenggunaanAlatBongkarMuatRepo;
    }

    /**
     * Display a listing of the ImptPenggunaanAlatBongkarMuat.
     */
    public function index(Request $request)
    {
        $imptPenggunaanAlatBongkarMuats = $this->imptPenggunaanAlatBongkarMuatRepository->paginate(10);

        return view('impt_penggunaan_alat_bongkar_muats.index')
            ->with('imptPenggunaanAlatBongkarMuats', $imptPenggunaanAlatBongkarMuats);
    }

    /**
     * Show the form for creating a new ImptPenggunaanAlatBongkarMuat.
     */
    public function create()
    {
        return view('impt_penggunaan_alat_bongkar_muats.create');
    }

    /**
     * Store a newly created ImptPenggunaanAlatBongkarMuat in storage.
     */
    public function store(CreateImptPenggunaanAlatBongkarMuatRequest $request)
    {
        $input = $request->all();

        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->create($input);

        Flash::success('Impt Penggunaan Alat Bongkar Muat saved successfully.');

        return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
    }

    /**
     * Display the specified ImptPenggunaanAlatBongkarMuat.
     */
    public function show($id)
    {
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            Flash::error('Impt Penggunaan Alat Bongkar Muat not found');

            return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
        }

        return view('impt_penggunaan_alat_bongkar_muats.show')->with('imptPenggunaanAlatBongkarMuat', $imptPenggunaanAlatBongkarMuat);
    }

    /**
     * Show the form for editing the specified ImptPenggunaanAlatBongkarMuat.
     */
    public function edit($id)
    {
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            Flash::error('Impt Penggunaan Alat Bongkar Muat not found');

            return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
        }

        return view('impt_penggunaan_alat_bongkar_muats.edit')->with('imptPenggunaanAlatBongkarMuat', $imptPenggunaanAlatBongkarMuat);
    }

    /**
     * Update the specified ImptPenggunaanAlatBongkarMuat in storage.
     */
    public function update($id, UpdateImptPenggunaanAlatBongkarMuatRequest $request)
    {
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            Flash::error('Impt Penggunaan Alat Bongkar Muat not found');

            return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
        }

        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->update($request->all(), $id);

        Flash::success('Impt Penggunaan Alat Bongkar Muat updated successfully.');

        return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
    }

    /**
     * Remove the specified ImptPenggunaanAlatBongkarMuat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            Flash::error('Impt Penggunaan Alat Bongkar Muat not found');

            return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
        }

        $this->imptPenggunaanAlatBongkarMuatRepository->delete($id);

        Flash::success('Impt Penggunaan Alat Bongkar Muat deleted successfully.');

        return redirect(route('imptPenggunaanAlatBongkarMuats.index'));
    }
}
