<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDataMandiriPelaksanaanKapalRequest;
use App\Http\Requests\UpdateDataMandiriPelaksanaanKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DataMandiriPelaksanaanKapalRepository;
use Illuminate\Http\Request;
use Flash;

class DataMandiriPelaksanaanKapalController extends AppBaseController
{
    /** @var DataMandiriPelaksanaanKapalRepository $dataMandiriPelaksanaanKapalRepository*/
    private $dataMandiriPelaksanaanKapalRepository;

    public function __construct(DataMandiriPelaksanaanKapalRepository $dataMandiriPelaksanaanKapalRepo)
    {
        $this->dataMandiriPelaksanaanKapalRepository = $dataMandiriPelaksanaanKapalRepo;
    }

    /**
     * Display a listing of the DataMandiriPelaksanaanKapal.
     */
    public function index(Request $request)
    {
        $dataMandiriPelaksanaanKapals = $this->dataMandiriPelaksanaanKapalRepository->paginate(10);

        return view('data_mandiri_pelaksanaan_kapals.index')
            ->with('dataMandiriPelaksanaanKapals', $dataMandiriPelaksanaanKapals);
    }

    /**
     * Show the form for creating a new DataMandiriPelaksanaanKapal.
     */
    public function create()
    {
        return view('data_mandiri_pelaksanaan_kapals.create');
    }

    /**
     * Store a newly created DataMandiriPelaksanaanKapal in storage.
     */
    public function store(CreateDataMandiriPelaksanaanKapalRequest $request)
    {
        $input = $request->all();

        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->create($input);

        Flash::success('Data Mandiri Pelaksanaan Kapal saved successfully.');

        return redirect(route('dataMandiriPelaksanaanKapals.index'));
    }

    /**
     * Display the specified DataMandiriPelaksanaanKapal.
     */
    public function show($id)
    {
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            Flash::error('Data Mandiri Pelaksanaan Kapal not found');

            return redirect(route('dataMandiriPelaksanaanKapals.index'));
        }

        return view('data_mandiri_pelaksanaan_kapals.show')->with('dataMandiriPelaksanaanKapal', $dataMandiriPelaksanaanKapal);
    }

    /**
     * Show the form for editing the specified DataMandiriPelaksanaanKapal.
     */
    public function edit($id)
    {
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            Flash::error('Data Mandiri Pelaksanaan Kapal not found');

            return redirect(route('dataMandiriPelaksanaanKapals.index'));
        }

        return view('data_mandiri_pelaksanaan_kapals.edit')->with('dataMandiriPelaksanaanKapal', $dataMandiriPelaksanaanKapal);
    }

    /**
     * Update the specified DataMandiriPelaksanaanKapal in storage.
     */
    public function update($id, UpdateDataMandiriPelaksanaanKapalRequest $request)
    {
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            Flash::error('Data Mandiri Pelaksanaan Kapal not found');

            return redirect(route('dataMandiriPelaksanaanKapals.index'));
        }

        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->update($request->all(), $id);

        Flash::success('Data Mandiri Pelaksanaan Kapal updated successfully.');

        return redirect(route('dataMandiriPelaksanaanKapals.index'));
    }

    /**
     * Remove the specified DataMandiriPelaksanaanKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dataMandiriPelaksanaanKapal = $this->dataMandiriPelaksanaanKapalRepository->find($id);

        if (empty($dataMandiriPelaksanaanKapal)) {
            Flash::error('Data Mandiri Pelaksanaan Kapal not found');

            return redirect(route('dataMandiriPelaksanaanKapals.index'));
        }

        $this->dataMandiriPelaksanaanKapalRepository->delete($id);

        Flash::success('Data Mandiri Pelaksanaan Kapal deleted successfully.');

        return redirect(route('dataMandiriPelaksanaanKapals.index'));
    }
}
