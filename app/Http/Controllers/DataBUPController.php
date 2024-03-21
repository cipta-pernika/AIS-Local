<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDataBUPRequest;
use App\Http\Requests\UpdateDataBUPRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DataBUPRepository;
use Illuminate\Http\Request;
use Flash;

class DataBUPController extends AppBaseController
{
    /** @var DataBUPRepository $dataBUPRepository*/
    private $dataBUPRepository;

    public function __construct(DataBUPRepository $dataBUPRepo)
    {
        $this->dataBUPRepository = $dataBUPRepo;
    }

    /**
     * Display a listing of the DataBUP.
     */
    public function index(Request $request)
    {
        $dataBUPs = $this->dataBUPRepository->paginate(10);

        return view('data_b_u_ps.index')
            ->with('dataBUPs', $dataBUPs);
    }

    /**
     * Show the form for creating a new DataBUP.
     */
    public function create()
    {
        return view('data_b_u_ps.create');
    }

    /**
     * Store a newly created DataBUP in storage.
     */
    public function store(CreateDataBUPRequest $request)
    {
        $input = $request->all();

        $dataBUP = $this->dataBUPRepository->create($input);

        Flash::success('Data B U P saved successfully.');

        return redirect(route('dataBUPs.index'));
    }

    /**
     * Display the specified DataBUP.
     */
    public function show($id)
    {
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            Flash::error('Data B U P not found');

            return redirect(route('dataBUPs.index'));
        }

        return view('data_b_u_ps.show')->with('dataBUP', $dataBUP);
    }

    /**
     * Show the form for editing the specified DataBUP.
     */
    public function edit($id)
    {
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            Flash::error('Data B U P not found');

            return redirect(route('dataBUPs.index'));
        }

        return view('data_b_u_ps.edit')->with('dataBUP', $dataBUP);
    }

    /**
     * Update the specified DataBUP in storage.
     */
    public function update($id, UpdateDataBUPRequest $request)
    {
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            Flash::error('Data B U P not found');

            return redirect(route('dataBUPs.index'));
        }

        $dataBUP = $this->dataBUPRepository->update($request->all(), $id);

        Flash::success('Data B U P updated successfully.');

        return redirect(route('dataBUPs.index'));
    }

    /**
     * Remove the specified DataBUP from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            Flash::error('Data B U P not found');

            return redirect(route('dataBUPs.index'));
        }

        $this->dataBUPRepository->delete($id);

        Flash::success('Data B U P deleted successfully.');

        return redirect(route('dataBUPs.index'));
    }
}
