<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImptPenggunaanAlatRequest;
use App\Http\Requests\UpdateImptPenggunaanAlatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ImptPenggunaanAlatRepository;
use Illuminate\Http\Request;
use Flash;

class ImptPenggunaanAlatController extends AppBaseController
{
    /** @var ImptPenggunaanAlatRepository $imptPenggunaanAlatRepository*/
    private $imptPenggunaanAlatRepository;

    public function __construct(ImptPenggunaanAlatRepository $imptPenggunaanAlatRepo)
    {
        $this->imptPenggunaanAlatRepository = $imptPenggunaanAlatRepo;
    }

    /**
     * Display a listing of the ImptPenggunaanAlat.
     */
    public function index(Request $request)
    {
        $imptPenggunaanAlats = $this->imptPenggunaanAlatRepository->paginate(10);

        return view('impt_penggunaan_alats.index')
            ->with('imptPenggunaanAlats', $imptPenggunaanAlats);
    }

    /**
     * Show the form for creating a new ImptPenggunaanAlat.
     */
    public function create()
    {
        return view('impt_penggunaan_alats.create');
    }

    /**
     * Store a newly created ImptPenggunaanAlat in storage.
     */
    public function store(CreateImptPenggunaanAlatRequest $request)
    {
        $input = $request->all();

        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->create($input);

        Flash::success('Impt Penggunaan Alat saved successfully.');

        return redirect(route('imptPenggunaanAlats.index'));
    }

    /**
     * Display the specified ImptPenggunaanAlat.
     */
    public function show($id)
    {
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            Flash::error('Impt Penggunaan Alat not found');

            return redirect(route('imptPenggunaanAlats.index'));
        }

        return view('impt_penggunaan_alats.show')->with('imptPenggunaanAlat', $imptPenggunaanAlat);
    }

    /**
     * Show the form for editing the specified ImptPenggunaanAlat.
     */
    public function edit($id)
    {
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            Flash::error('Impt Penggunaan Alat not found');

            return redirect(route('imptPenggunaanAlats.index'));
        }

        return view('impt_penggunaan_alats.edit')->with('imptPenggunaanAlat', $imptPenggunaanAlat);
    }

    /**
     * Update the specified ImptPenggunaanAlat in storage.
     */
    public function update($id, UpdateImptPenggunaanAlatRequest $request)
    {
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            Flash::error('Impt Penggunaan Alat not found');

            return redirect(route('imptPenggunaanAlats.index'));
        }

        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->update($request->all(), $id);

        Flash::success('Impt Penggunaan Alat updated successfully.');

        return redirect(route('imptPenggunaanAlats.index'));
    }

    /**
     * Remove the specified ImptPenggunaanAlat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            Flash::error('Impt Penggunaan Alat not found');

            return redirect(route('imptPenggunaanAlats.index'));
        }

        $this->imptPenggunaanAlatRepository->delete($id);

        Flash::success('Impt Penggunaan Alat deleted successfully.');

        return redirect(route('imptPenggunaanAlats.index'));
    }
}
