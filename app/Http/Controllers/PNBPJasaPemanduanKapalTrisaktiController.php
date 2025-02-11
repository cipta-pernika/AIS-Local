<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaPemanduanKapalTrisaktiRequest;
use App\Http\Requests\UpdatePNBPJasaPemanduanKapalTrisaktiRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaPemanduanKapalTrisaktiRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaPemanduanKapalTrisaktiController extends AppBaseController
{
    /** @var PNBPJasaPemanduanKapalTrisaktiRepository $pNBPJasaPemanduanKapalTrisaktiRepository*/
    private $pNBPJasaPemanduanKapalTrisaktiRepository;

    public function __construct(PNBPJasaPemanduanKapalTrisaktiRepository $pNBPJasaPemanduanKapalTrisaktiRepo)
    {
        $this->pNBPJasaPemanduanKapalTrisaktiRepository = $pNBPJasaPemanduanKapalTrisaktiRepo;
    }

    /**
     * Display a listing of the PNBPJasaPemanduanKapalTrisakti.
     */
    public function index(Request $request)
    {
        $pNBPJasaPemanduanKapalTrisaktis = $this->pNBPJasaPemanduanKapalTrisaktiRepository->paginate(10);

        return view('p_n_b_p_jasa_pemanduan_kapal_trisaktis.index')
            ->with('pNBPJasaPemanduanKapalTrisaktis', $pNBPJasaPemanduanKapalTrisaktis);
    }

    /**
     * Show the form for creating a new PNBPJasaPemanduanKapalTrisakti.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_pemanduan_kapal_trisaktis.create');
    }

    /**
     * Store a newly created PNBPJasaPemanduanKapalTrisakti in storage.
     */
    public function store(CreatePNBPJasaPemanduanKapalTrisaktiRequest $request)
    {
        $input = $request->all();

        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->create($input);

        Flash::success('P N B P Jasa Pemanduan Kapal Trisakti saved successfully.');

        return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
    }

    /**
     * Display the specified PNBPJasaPemanduanKapalTrisakti.
     */
    public function show($id)
    {
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Trisakti not found');

            return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
        }

        return view('p_n_b_p_jasa_pemanduan_kapal_trisaktis.show')->with('pNBPJasaPemanduanKapalTrisakti', $pNBPJasaPemanduanKapalTrisakti);
    }

    /**
     * Show the form for editing the specified PNBPJasaPemanduanKapalTrisakti.
     */
    public function edit($id)
    {
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Trisakti not found');

            return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
        }

        return view('p_n_b_p_jasa_pemanduan_kapal_trisaktis.edit')->with('pNBPJasaPemanduanKapalTrisakti', $pNBPJasaPemanduanKapalTrisakti);
    }

    /**
     * Update the specified PNBPJasaPemanduanKapalTrisakti in storage.
     */
    public function update($id, UpdatePNBPJasaPemanduanKapalTrisaktiRequest $request)
    {
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Trisakti not found');

            return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
        }

        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Pemanduan Kapal Trisakti updated successfully.');

        return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
    }

    /**
     * Remove the specified PNBPJasaPemanduanKapalTrisakti from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Trisakti not found');

            return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
        }

        $this->pNBPJasaPemanduanKapalTrisaktiRepository->delete($id);

        Flash::success('P N B P Jasa Pemanduan Kapal Trisakti deleted successfully.');

        return redirect(route('pNBPJasaPemanduanKapalTrisaktis.index'));
    }
}
