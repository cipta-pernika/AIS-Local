<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePNBPJasaPemanduanKapalMarabahanRequest;
use App\Http\Requests\UpdatePNBPJasaPemanduanKapalMarabahanRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PNBPJasaPemanduanKapalMarabahanRepository;
use Illuminate\Http\Request;
use Flash;

class PNBPJasaPemanduanKapalMarabahanController extends AppBaseController
{
    /** @var PNBPJasaPemanduanKapalMarabahanRepository $pNBPJasaPemanduanKapalMarabahanRepository*/
    private $pNBPJasaPemanduanKapalMarabahanRepository;

    public function __construct(PNBPJasaPemanduanKapalMarabahanRepository $pNBPJasaPemanduanKapalMarabahanRepo)
    {
        $this->pNBPJasaPemanduanKapalMarabahanRepository = $pNBPJasaPemanduanKapalMarabahanRepo;
    }

    /**
     * Display a listing of the PNBPJasaPemanduanKapalMarabahan.
     */
    public function index(Request $request)
    {
        $pNBPJasaPemanduanKapalMarabahans = $this->pNBPJasaPemanduanKapalMarabahanRepository->paginate(10);

        return view('p_n_b_p_jasa_pemanduan_kapal_marabahans.index')
            ->with('pNBPJasaPemanduanKapalMarabahans', $pNBPJasaPemanduanKapalMarabahans);
    }

    /**
     * Show the form for creating a new PNBPJasaPemanduanKapalMarabahan.
     */
    public function create()
    {
        return view('p_n_b_p_jasa_pemanduan_kapal_marabahans.create');
    }

    /**
     * Store a newly created PNBPJasaPemanduanKapalMarabahan in storage.
     */
    public function store(CreatePNBPJasaPemanduanKapalMarabahanRequest $request)
    {
        $input = $request->all();

        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->create($input);

        Flash::success('P N B P Jasa Pemanduan Kapal Marabahan saved successfully.');

        return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
    }

    /**
     * Display the specified PNBPJasaPemanduanKapalMarabahan.
     */
    public function show($id)
    {
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Marabahan not found');

            return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
        }

        return view('p_n_b_p_jasa_pemanduan_kapal_marabahans.show')->with('pNBPJasaPemanduanKapalMarabahan', $pNBPJasaPemanduanKapalMarabahan);
    }

    /**
     * Show the form for editing the specified PNBPJasaPemanduanKapalMarabahan.
     */
    public function edit($id)
    {
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Marabahan not found');

            return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
        }

        return view('p_n_b_p_jasa_pemanduan_kapal_marabahans.edit')->with('pNBPJasaPemanduanKapalMarabahan', $pNBPJasaPemanduanKapalMarabahan);
    }

    /**
     * Update the specified PNBPJasaPemanduanKapalMarabahan in storage.
     */
    public function update($id, UpdatePNBPJasaPemanduanKapalMarabahanRequest $request)
    {
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Marabahan not found');

            return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
        }

        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->update($request->all(), $id);

        Flash::success('P N B P Jasa Pemanduan Kapal Marabahan updated successfully.');

        return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
    }

    /**
     * Remove the specified PNBPJasaPemanduanKapalMarabahan from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            Flash::error('P N B P Jasa Pemanduan Kapal Marabahan not found');

            return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
        }

        $this->pNBPJasaPemanduanKapalMarabahanRepository->delete($id);

        Flash::success('P N B P Jasa Pemanduan Kapal Marabahan deleted successfully.');

        return redirect(route('pNBPJasaPemanduanKapalMarabahans.index'));
    }
}
