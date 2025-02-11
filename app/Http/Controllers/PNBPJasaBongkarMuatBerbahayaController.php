<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaBongkarMuatBerbahayaRequest;
use App\Http\Requests\UpdatePNBPJasaBongkarMuatBerbahayaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaBongkarMuatBerbahayaRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaBongkarMuatBerbahayaController extends AppBaseController
{
    /** @var PNBPJasaBongkarMuatBerbahayaRepository $pNBPJasaBongkarMuatBerbahayaRepository*/
    private $pNBPJasaBongkarMuatBerbahayaRepository;

    public function __construct(PNBPJasaBongkarMuatBerbahayaRepository $pNBPJasaBongkarMuatBerbahayaRepo)
    {
        $this->pNBPJasaBongkarMuatBerbahayaRepository = $pNBPJasaBongkarMuatBerbahayaRepo;
    }

    /**
     * Display a listing of the PNBPJasaBongkarMuatBerbahaya.
     */
    public function index(Request $request)
    {
        $pNBPJasaBongkarMuatBerbahayas = $this->pNBPJasaBongkarMuatBerbahayaRepository->paginate(10);

        return view('p_n_b_p_jasa_bongkar_muat_berbahayas.index')
            ->with('pNBPJasaBongkarMuatBerbahayas', $pNBPJasaBongkarMuatBerbahayas);
    }

    /**
     * Show the form for creating a new PNBPJasaBongkarMuatBerbahaya.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_bongkar_muat_berbahayas.create');
    }

    /**
     * Store a newly created PNBPJasaBongkarMuatBerbahaya in storage.
     */
    public function store(CreatePNBPJasaBongkarMuatBerbahayaRequest $request)
    {
        $input = $request->all();

        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->create($input);

        Flash::success('P N B P Jasa Bongkar Muat Berbahaya saved successfully.');

        return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
    }

    /**
     * Display the specified PNBPJasaBongkarMuatBerbahaya.
     */
    public function show($id)
    {
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            Flash::error('P N B P Jasa Bongkar Muat Berbahaya not found');

            return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
        }

        return view('p_n_b_p_jasa_bongkar_muat_berbahayas.show')->with('pNBPJasaBongkarMuatBerbahaya', $pNBPJasaBongkarMuatBerbahaya);
    }

    /**
     * Show the form for editing the specified PNBPJasaBongkarMuatBerbahaya.
     */
    public function edit($id)
    {
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            Flash::error('P N B P Jasa Bongkar Muat Berbahaya not found');

            return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
        }

        return view('p_n_b_p_jasa_bongkar_muat_berbahayas.edit')->with('pNBPJasaBongkarMuatBerbahaya', $pNBPJasaBongkarMuatBerbahaya);
    }

    /**
     * Update the specified PNBPJasaBongkarMuatBerbahaya in storage.
     */
    public function update($id, UpdatePNBPJasaBongkarMuatBerbahayaRequest $request)
    {
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            Flash::error('P N B P Jasa Bongkar Muat Berbahaya not found');

            return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
        }

        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Bongkar Muat Berbahaya updated successfully.');

        return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
    }

    /**
     * Remove the specified PNBPJasaBongkarMuatBerbahaya from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            Flash::error('P N B P Jasa Bongkar Muat Berbahaya not found');

            return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
        }

        $this->pNBPJasaBongkarMuatBerbahayaRepository->delete($id);

        Flash::success('P N B P Jasa Bongkar Muat Berbahaya deleted successfully.');

        return redirect(route('pNBPJasaBongkarMuatBerbahayas.index'));
    }
}
