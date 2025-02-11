<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImptPelayananKapalRequest;
use App\Http\Requests\UpdateImptPelayananKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ImptPelayananKapalRepository;
use Illuminate\Http\Request;
use Flash;

class ImptPelayananKapalController extends AppBaseController
{
    /** @var ImptPelayananKapalRepository $imptPelayananKapalRepository*/
    private $imptPelayananKapalRepository;

    public function __construct(ImptPelayananKapalRepository $imptPelayananKapalRepo)
    {
        $this->imptPelayananKapalRepository = $imptPelayananKapalRepo;
    }

    /**
     * Display a listing of the ImptPelayananKapal.
     */
    public function index(Request $request)
    {
        $imptPelayananKapals = $this->imptPelayananKapalRepository->paginate(10);

        return view('impt_pelayanan_kapals.index')
            ->with('imptPelayananKapals', $imptPelayananKapals);
    }

    /**
     * Show the form for creating a new ImptPelayananKapal.
     */
    public function create()
    {
        return view('impt_pelayanan_kapals.create');
    }

    /**
     * Store a newly created ImptPelayananKapal in storage.
     */
    public function store(CreateImptPelayananKapalRequest $request)
    {
        $input = $request->all();

        $imptPelayananKapal = $this->imptPelayananKapalRepository->create($input);

        Flash::success('Impt Pelayanan Kapal saved successfully.');

        return redirect(route('imptPelayananKapals.index'));
    }

    /**
     * Display the specified ImptPelayananKapal.
     */
    public function show($id)
    {
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            Flash::error('Impt Pelayanan Kapal not found');

            return redirect(route('imptPelayananKapals.index'));
        }

        return view('impt_pelayanan_kapals.show')->with('imptPelayananKapal', $imptPelayananKapal);
    }

    /**
     * Show the form for editing the specified ImptPelayananKapal.
     */
    public function edit($id)
    {
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            Flash::error('Impt Pelayanan Kapal not found');

            return redirect(route('imptPelayananKapals.index'));
        }

        return view('impt_pelayanan_kapals.edit')->with('imptPelayananKapal', $imptPelayananKapal);
    }

    /**
     * Update the specified ImptPelayananKapal in storage.
     */
    public function update($id, UpdateImptPelayananKapalRequest $request)
    {
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            Flash::error('Impt Pelayanan Kapal not found');

            return redirect(route('imptPelayananKapals.index'));
        }

        $imptPelayananKapal = $this->imptPelayananKapalRepository->update($request->all(), $id);

        Flash::success('Impt Pelayanan Kapal updated successfully.');

        return redirect(route('imptPelayananKapals.index'));
    }

    /**
     * Remove the specified ImptPelayananKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            Flash::error('Impt Pelayanan Kapal not found');

            return redirect(route('imptPelayananKapals.index'));
        }

        $this->imptPelayananKapalRepository->delete($id);

        Flash::success('Impt Pelayanan Kapal deleted successfully.');

        return redirect(route('imptPelayananKapals.index'));
    }
}
