<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaVTSKapalRequest;
use App\Http\Requests\UpdatePNBPJasaVTSKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaVTSKapalRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaVTSKapalController extends AppBaseController
{
    /** @var PNBPJasaVTSKapalRepository $pNBPJasaVTSKapalRepository*/
    private $pNBPJasaVTSKapalRepository;

    public function __construct(PNBPJasaVTSKapalRepository $pNBPJasaVTSKapalRepo)
    {
        $this->pNBPJasaVTSKapalRepository = $pNBPJasaVTSKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaVTSKapal.
     */
    public function index(Request $request)
    {
        $pNBPJasaVTSKapals = $this->pNBPJasaVTSKapalRepository->paginate(10);

        return view('p_n_b_p_jasa_v_t_s_kapals.index')
            ->with('pNBPJasaVTSKapals', $pNBPJasaVTSKapals);
    }

    /**
     * Show the form for creating a new PNBPJasaVTSKapal.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_v_t_s_kapals.create');
    }

    /**
     * Store a newly created PNBPJasaVTSKapal in storage.
     */
    public function store(CreatePNBPJasaVTSKapalRequest $request)
    {
        $input = $request->all();

        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->create($input);

        Flash::success('P N B P Jasa V T S Kapal saved successfully.');

        return redirect(route('pNBPJasaVTSKapals.index'));
    }

    /**
     * Display the specified PNBPJasaVTSKapal.
     */
    public function show($id)
    {
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            Flash::error('P N B P Jasa V T S Kapal not found');

            return redirect(route('pNBPJasaVTSKapals.index'));
        }

        return view('p_n_b_p_jasa_v_t_s_kapals.show')->with('pNBPJasaVTSKapal', $pNBPJasaVTSKapal);
    }

    /**
     * Show the form for editing the specified PNBPJasaVTSKapal.
     */
    public function edit($id)
    {
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            Flash::error('P N B P Jasa V T S Kapal not found');

            return redirect(route('pNBPJasaVTSKapals.index'));
        }

        return view('p_n_b_p_jasa_v_t_s_kapals.edit')->with('pNBPJasaVTSKapal', $pNBPJasaVTSKapal);
    }

    /**
     * Update the specified PNBPJasaVTSKapal in storage.
     */
    public function update($id, UpdatePNBPJasaVTSKapalRequest $request)
    {
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            Flash::error('P N B P Jasa V T S Kapal not found');

            return redirect(route('pNBPJasaVTSKapals.index'));
        }

        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa V T S Kapal updated successfully.');

        return redirect(route('pNBPJasaVTSKapals.index'));
    }

    /**
     * Remove the specified PNBPJasaVTSKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            Flash::error('P N B P Jasa V T S Kapal not found');

            return redirect(route('pNBPJasaVTSKapals.index'));
        }

        $this->pNBPJasaVTSKapalRepository->delete($id);

        Flash::success('P N B P Jasa V T S Kapal deleted successfully.');

        return redirect(route('pNBPJasaVTSKapals.index'));
    }
}
