<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaTambatKapalRequest;
use App\Http\Requests\UpdatePNBPJasaTambatKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaTambatKapalRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaTambatKapalController extends AppBaseController
{
    /** @var PNBPJasaTambatKapalRepository $pNBPJasaTambatKapalRepository*/
    private $pNBPJasaTambatKapalRepository;

    public function __construct(PNBPJasaTambatKapalRepository $pNBPJasaTambatKapalRepo)
    {
        $this->pNBPJasaTambatKapalRepository = $pNBPJasaTambatKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaTambatKapal.
     */
    public function index(Request $request)
    {
        $pNBPJasaTambatKapals = $this->pNBPJasaTambatKapalRepository->paginate(10);

        return view('p_n_b_p_jasa_tambat_kapals.index')
            ->with('pNBPJasaTambatKapals', $pNBPJasaTambatKapals);
    }

    /**
     * Show the form for creating a new PNBPJasaTambatKapal.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_tambat_kapals.create');
    }

    /**
     * Store a newly created PNBPJasaTambatKapal in storage.
     */
    public function store(CreatePNBPJasaTambatKapalRequest $request)
    {
        $input = $request->all();

        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->create($input);

        Flash::success('P N B P Jasa Tambat Kapal saved successfully.');

        return redirect(route('pNBPJasaTambatKapals.index'));
    }

    /**
     * Display the specified PNBPJasaTambatKapal.
     */
    public function show($id)
    {
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            Flash::error('P N B P Jasa Tambat Kapal not found');

            return redirect(route('pNBPJasaTambatKapals.index'));
        }

        return view('p_n_b_p_jasa_tambat_kapals.show')->with('pNBPJasaTambatKapal', $pNBPJasaTambatKapal);
    }

    /**
     * Show the form for editing the specified PNBPJasaTambatKapal.
     */
    public function edit($id)
    {
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            Flash::error('P N B P Jasa Tambat Kapal not found');

            return redirect(route('pNBPJasaTambatKapals.index'));
        }

        return view('p_n_b_p_jasa_tambat_kapals.edit')->with('pNBPJasaTambatKapal', $pNBPJasaTambatKapal);
    }

    /**
     * Update the specified PNBPJasaTambatKapal in storage.
     */
    public function update($id, UpdatePNBPJasaTambatKapalRequest $request)
    {
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            Flash::error('P N B P Jasa Tambat Kapal not found');

            return redirect(route('pNBPJasaTambatKapals.index'));
        }

        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Tambat Kapal updated successfully.');

        return redirect(route('pNBPJasaTambatKapals.index'));
    }

    /**
     * Remove the specified PNBPJasaTambatKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            Flash::error('P N B P Jasa Tambat Kapal not found');

            return redirect(route('pNBPJasaTambatKapals.index'));
        }

        $this->pNBPJasaTambatKapalRepository->delete($id);

        Flash::success('P N B P Jasa Tambat Kapal deleted successfully.');

        return redirect(route('pNBPJasaTambatKapals.index'));
    }
}
