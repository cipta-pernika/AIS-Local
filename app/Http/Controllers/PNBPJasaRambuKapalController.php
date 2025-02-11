<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaRambuKapalRequest;
use App\Http\Requests\UpdatePNBPJasaRambuKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaRambuKapalRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaRambuKapalController extends AppBaseController
{
    /** @var PNBPJasaRambuKapalRepository $pNBPJasaRambuKapalRepository*/
    private $pNBPJasaRambuKapalRepository;

    public function __construct(PNBPJasaRambuKapalRepository $pNBPJasaRambuKapalRepo)
    {
        $this->pNBPJasaRambuKapalRepository = $pNBPJasaRambuKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaRambuKapal.
     */
    public function index(Request $request)
    {
        $pNBPJasaRambuKapals = $this->pNBPJasaRambuKapalRepository->paginate(10);

        return view('p_n_b_p_jasa_rambu_kapals.index')
            ->with('pNBPJasaRambuKapals', $pNBPJasaRambuKapals);
    }

    /**
     * Show the form for creating a new PNBPJasaRambuKapal.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_rambu_kapals.create');
    }

    /**
     * Store a newly created PNBPJasaRambuKapal in storage.
     */
    public function store(CreatePNBPJasaRambuKapalRequest $request)
    {
        $input = $request->all();

        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->create($input);

        Flash::success('P N B P Jasa Rambu Kapal saved successfully.');

        return redirect(route('pNBPJasaRambuKapals.index'));
    }

    /**
     * Display the specified PNBPJasaRambuKapal.
     */
    public function show($id)
    {
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            Flash::error('P N B P Jasa Rambu Kapal not found');

            return redirect(route('pNBPJasaRambuKapals.index'));
        }

        return view('p_n_b_p_jasa_rambu_kapals.show')->with('pNBPJasaRambuKapal', $pNBPJasaRambuKapal);
    }

    /**
     * Show the form for editing the specified PNBPJasaRambuKapal.
     */
    public function edit($id)
    {
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            Flash::error('P N B P Jasa Rambu Kapal not found');

            return redirect(route('pNBPJasaRambuKapals.index'));
        }

        return view('p_n_b_p_jasa_rambu_kapals.edit')->with('pNBPJasaRambuKapal', $pNBPJasaRambuKapal);
    }

    /**
     * Update the specified PNBPJasaRambuKapal in storage.
     */
    public function update($id, UpdatePNBPJasaRambuKapalRequest $request)
    {
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            Flash::error('P N B P Jasa Rambu Kapal not found');

            return redirect(route('pNBPJasaRambuKapals.index'));
        }

        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Rambu Kapal updated successfully.');

        return redirect(route('pNBPJasaRambuKapals.index'));
    }

    /**
     * Remove the specified PNBPJasaRambuKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            Flash::error('P N B P Jasa Rambu Kapal not found');

            return redirect(route('pNBPJasaRambuKapals.index'));
        }

        $this->pNBPJasaRambuKapalRepository->delete($id);

        Flash::success('P N B P Jasa Rambu Kapal deleted successfully.');

        return redirect(route('pNBPJasaRambuKapals.index'));
    }
}
