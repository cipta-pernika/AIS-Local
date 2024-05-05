<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaVTSKapalAsingRequest;
use App\Http\Requests\UpdatePNBPJasaVTSKapalAsingRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaVTSKapalAsingRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaVTSKapalAsingController extends AppBaseController
{
    /** @var PNBPJasaVTSKapalAsingRepository $pNBPJasaVTSKapalAsingRepository*/
    private $pNBPJasaVTSKapalAsingRepository;

    public function __construct(PNBPJasaVTSKapalAsingRepository $pNBPJasaVTSKapalAsingRepo)
    {
        $this->pNBPJasaVTSKapalAsingRepository = $pNBPJasaVTSKapalAsingRepo;
    }

    /**
     * Display a listing of the PNBPJasaVTSKapalAsing.
     */
    public function index(Request $request)
    {
        $pNBPJasaVTSKapalAsings = $this->pNBPJasaVTSKapalAsingRepository->paginate(10);

        return view('p_n_b_p_jasa_v_t_s_kapal_asings.index')
            ->with('pNBPJasaVTSKapalAsings', $pNBPJasaVTSKapalAsings);
    }

    /**
     * Show the form for creating a new PNBPJasaVTSKapalAsing.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_v_t_s_kapal_asings.create');
    }

    /**
     * Store a newly created PNBPJasaVTSKapalAsing in storage.
     */
    public function store(CreatePNBPJasaVTSKapalAsingRequest $request)
    {
        $input = $request->all();

        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->create($input);

        Flash::success('P N B P Jasa V T S Kapal Asing saved successfully.');

        return redirect(route('pNBPJasaVTSKapalAsings.index'));
    }

    /**
     * Display the specified PNBPJasaVTSKapalAsing.
     */
    public function show($id)
    {
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            Flash::error('P N B P Jasa V T S Kapal Asing not found');

            return redirect(route('pNBPJasaVTSKapalAsings.index'));
        }

        return view('p_n_b_p_jasa_v_t_s_kapal_asings.show')->with('pNBPJasaVTSKapalAsing', $pNBPJasaVTSKapalAsing);
    }

    /**
     * Show the form for editing the specified PNBPJasaVTSKapalAsing.
     */
    public function edit($id)
    {
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            Flash::error('P N B P Jasa V T S Kapal Asing not found');

            return redirect(route('pNBPJasaVTSKapalAsings.index'));
        }

        return view('p_n_b_p_jasa_v_t_s_kapal_asings.edit')->with('pNBPJasaVTSKapalAsing', $pNBPJasaVTSKapalAsing);
    }

    /**
     * Update the specified PNBPJasaVTSKapalAsing in storage.
     */
    public function update($id, UpdatePNBPJasaVTSKapalAsingRequest $request)
    {
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            Flash::error('P N B P Jasa V T S Kapal Asing not found');

            return redirect(route('pNBPJasaVTSKapalAsings.index'));
        }

        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa V T S Kapal Asing updated successfully.');

        return redirect(route('pNBPJasaVTSKapalAsings.index'));
    }

    /**
     * Remove the specified PNBPJasaVTSKapalAsing from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            Flash::error('P N B P Jasa V T S Kapal Asing not found');

            return redirect(route('pNBPJasaVTSKapalAsings.index'));
        }

        $this->pNBPJasaVTSKapalAsingRepository->delete($id);

        Flash::success('P N B P Jasa V T S Kapal Asing deleted successfully.');

        return redirect(route('pNBPJasaVTSKapalAsings.index'));
    }
}
