<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaPengawasanBongkarMuatRequest;
use App\Http\Requests\UpdatePNBPJasaPengawasanBongkarMuatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaPengawasanBongkarMuatRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaPengawasanBongkarMuatController extends AppBaseController
{
    /** @var PNBPJasaPengawasanBongkarMuatRepository $pNBPJasaPengawasanBongkarMuatRepository*/
    private $pNBPJasaPengawasanBongkarMuatRepository;

    public function __construct(PNBPJasaPengawasanBongkarMuatRepository $pNBPJasaPengawasanBongkarMuatRepo)
    {
        $this->pNBPJasaPengawasanBongkarMuatRepository = $pNBPJasaPengawasanBongkarMuatRepo;
    }

    /**
     * Display a listing of the PNBPJasaPengawasanBongkarMuat.
     */
    public function index(Request $request)
    {
        $pNBPJasaPengawasanBongkarMuats = $this->pNBPJasaPengawasanBongkarMuatRepository->paginate(10);

        return view('p_n_b_p_jasa_pengawasan_bongkar_muats.index')
            ->with('pNBPJasaPengawasanBongkarMuats', $pNBPJasaPengawasanBongkarMuats);
    }

    /**
     * Show the form for creating a new PNBPJasaPengawasanBongkarMuat.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_pengawasan_bongkar_muats.create');
    }

    /**
     * Store a newly created PNBPJasaPengawasanBongkarMuat in storage.
     */
    public function store(CreatePNBPJasaPengawasanBongkarMuatRequest $request)
    {
        $input = $request->all();

        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->create($input);

        Flash::success('P N B P Jasa Pengawasan Bongkar Muat saved successfully.');

        return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
    }

    /**
     * Display the specified PNBPJasaPengawasanBongkarMuat.
     */
    public function show($id)
    {
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            Flash::error('P N B P Jasa Pengawasan Bongkar Muat not found');

            return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
        }

        return view('p_n_b_p_jasa_pengawasan_bongkar_muats.show')->with('pNBPJasaPengawasanBongkarMuat', $pNBPJasaPengawasanBongkarMuat);
    }

    /**
     * Show the form for editing the specified PNBPJasaPengawasanBongkarMuat.
     */
    public function edit($id)
    {
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            Flash::error('P N B P Jasa Pengawasan Bongkar Muat not found');

            return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
        }

        return view('p_n_b_p_jasa_pengawasan_bongkar_muats.edit')->with('pNBPJasaPengawasanBongkarMuat', $pNBPJasaPengawasanBongkarMuat);
    }

    /**
     * Update the specified PNBPJasaPengawasanBongkarMuat in storage.
     */
    public function update($id, UpdatePNBPJasaPengawasanBongkarMuatRequest $request)
    {
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            Flash::error('P N B P Jasa Pengawasan Bongkar Muat not found');

            return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
        }

        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Pengawasan Bongkar Muat updated successfully.');

        return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
    }

    /**
     * Remove the specified PNBPJasaPengawasanBongkarMuat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            Flash::error('P N B P Jasa Pengawasan Bongkar Muat not found');

            return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
        }

        $this->pNBPJasaPengawasanBongkarMuatRepository->delete($id);

        Flash::success('P N B P Jasa Pengawasan Bongkar Muat deleted successfully.');

        return redirect(route('pNBPJasaPengawasanBongkarMuats.index'));
    }
}
