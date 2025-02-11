<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaLabuhKapalRequest;
use App\Http\Requests\UpdatePNBPJasaLabuhKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaLabuhKapalRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaLabuhKapalController extends AppBaseController
{
    /** @var PNBPJasaLabuhKapalRepository $pNBPJasaLabuhKapalRepository*/
    private $pNBPJasaLabuhKapalRepository;

    public function __construct(PNBPJasaLabuhKapalRepository $pNBPJasaLabuhKapalRepo)
    {
        $this->pNBPJasaLabuhKapalRepository = $pNBPJasaLabuhKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaLabuhKapal.
     */
    public function index(Request $request)
    {
        $pNBPJasaLabuhKapals = $this->pNBPJasaLabuhKapalRepository->paginate(10);

        return view('p_n_b_p_jasa_labuh_kapals.index')
            ->with('pNBPJasaLabuhKapals', $pNBPJasaLabuhKapals);
    }

    /**
     * Show the form for creating a new PNBPJasaLabuhKapal.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_labuh_kapals.create');
    }

    /**
     * Store a newly created PNBPJasaLabuhKapal in storage.
     */
    public function store(CreatePNBPJasaLabuhKapalRequest $request)
    {
        $input = $request->all();

        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->create($input);

        Flash::success('P N B P Jasa Labuh Kapal saved successfully.');

        return redirect(route('pNBPJasaLabuhKapals.index'));
    }

    /**
     * Display the specified PNBPJasaLabuhKapal.
     */
    public function show($id)
    {
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            Flash::error('P N B P Jasa Labuh Kapal not found');

            return redirect(route('pNBPJasaLabuhKapals.index'));
        }

        return view('p_n_b_p_jasa_labuh_kapals.show')->with('pNBPJasaLabuhKapal', $pNBPJasaLabuhKapal);
    }

    /**
     * Show the form for editing the specified PNBPJasaLabuhKapal.
     */
    public function edit($id)
    {
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            Flash::error('P N B P Jasa Labuh Kapal not found');

            return redirect(route('pNBPJasaLabuhKapals.index'));
        }

        return view('p_n_b_p_jasa_labuh_kapals.edit')->with('pNBPJasaLabuhKapal', $pNBPJasaLabuhKapal);
    }

    /**
     * Update the specified PNBPJasaLabuhKapal in storage.
     */
    public function update($id, UpdatePNBPJasaLabuhKapalRequest $request)
    {
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            Flash::error('P N B P Jasa Labuh Kapal not found');

            return redirect(route('pNBPJasaLabuhKapals.index'));
        }

        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Labuh Kapal updated successfully.');

        return redirect(route('pNBPJasaLabuhKapals.index'));
    }

    /**
     * Remove the specified PNBPJasaLabuhKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            Flash::error('P N B P Jasa Labuh Kapal not found');

            return redirect(route('pNBPJasaLabuhKapals.index'));
        }

        $this->pNBPJasaLabuhKapalRepository->delete($id);

        Flash::success('P N B P Jasa Labuh Kapal deleted successfully.');

        return redirect(route('pNBPJasaLabuhKapals.index'));
    }
}
