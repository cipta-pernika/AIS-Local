<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaBarangRequest;
use App\Http\Requests\UpdatePNBPJasaBarangRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaBarangRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaBarangController extends AppBaseController
{
    /** @var PNBPJasaBarangRepository $pNBPJasaBarangRepository*/
    private $pNBPJasaBarangRepository;

    public function __construct(PNBPJasaBarangRepository $pNBPJasaBarangRepo)
    {
        $this->pNBPJasaBarangRepository = $pNBPJasaBarangRepo;
    }

    /**
     * Display a listing of the PNBPJasaBarang.
     */
    public function index(Request $request)
    {
        $pNBPJasaBarangs = $this->pNBPJasaBarangRepository->paginate(10);

        return view('p_n_b_p_jasa_barangs.index')
            ->with('pNBPJasaBarangs', $pNBPJasaBarangs);
    }

    /**
     * Show the form for creating a new PNBPJasaBarang.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_barangs.create');
    }

    /**
     * Store a newly created PNBPJasaBarang in storage.
     */
    public function store(CreatePNBPJasaBarangRequest $request)
    {
        $input = $request->all();

        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->create($input);

        Flash::success('P N B P Jasa Barang saved successfully.');

        return redirect(route('pNBPJasaBarangs.index'));
    }

    /**
     * Display the specified PNBPJasaBarang.
     */
    public function show($id)
    {
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            Flash::error('P N B P Jasa Barang not found');

            return redirect(route('pNBPJasaBarangs.index'));
        }

        return view('p_n_b_p_jasa_barangs.show')->with('pNBPJasaBarang', $pNBPJasaBarang);
    }

    /**
     * Show the form for editing the specified PNBPJasaBarang.
     */
    public function edit($id)
    {
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            Flash::error('P N B P Jasa Barang not found');

            return redirect(route('pNBPJasaBarangs.index'));
        }

        return view('p_n_b_p_jasa_barangs.edit')->with('pNBPJasaBarang', $pNBPJasaBarang);
    }

    /**
     * Update the specified PNBPJasaBarang in storage.
     */
    public function update($id, UpdatePNBPJasaBarangRequest $request)
    {
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            Flash::error('P N B P Jasa Barang not found');

            return redirect(route('pNBPJasaBarangs.index'));
        }

        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Barang updated successfully.');

        return redirect(route('pNBPJasaBarangs.index'));
    }

    /**
     * Remove the specified PNBPJasaBarang from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            Flash::error('P N B P Jasa Barang not found');

            return redirect(route('pNBPJasaBarangs.index'));
        }

        $this->pNBPJasaBarangRepository->delete($id);

        Flash::success('P N B P Jasa Barang deleted successfully.');

        return redirect(route('pNBPJasaBarangs.index'));
    }
}
