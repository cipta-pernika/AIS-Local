<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKonsolidasiRequest;
use App\Http\Requests\UpdateKonsolidasiRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\KonsolidasiRepository;
use Illuminate\Http\Request;
use Flash;

class KonsolidasiController extends AppBaseController
{
    /** @var KonsolidasiRepository $konsolidasiRepository*/
    private $konsolidasiRepository;

    public function __construct(KonsolidasiRepository $konsolidasiRepo)
    {
        $this->konsolidasiRepository = $konsolidasiRepo;
    }

    /**
     * Display a listing of the Konsolidasi.
     */
    public function index(Request $request)
    {
        $konsolidasis = $this->konsolidasiRepository->paginate(10);

        return view('konsolidasis.index')
            ->with('konsolidasis', $konsolidasis);
    }

    /**
     * Show the form for creating a new Konsolidasi.
     */
    public function create()
    {
        return view('konsolidasis.create');
    }

    /**
     * Store a newly created Konsolidasi in storage.
     */
    public function store(CreateKonsolidasiRequest $request)
    {
        $input = $request->all();

        $konsolidasi = $this->konsolidasiRepository->create($input);

        Flash::success('Konsolidasi saved successfully.');

        return redirect(route('konsolidasis.index'));
    }

    /**
     * Display the specified Konsolidasi.
     */
    public function show($id)
    {
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            Flash::error('Konsolidasi not found');

            return redirect(route('konsolidasis.index'));
        }

        return view('konsolidasis.show')->with('konsolidasi', $konsolidasi);
    }

    /**
     * Show the form for editing the specified Konsolidasi.
     */
    public function edit($id)
    {
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            Flash::error('Konsolidasi not found');

            return redirect(route('konsolidasis.index'));
        }

        return view('konsolidasis.edit')->with('konsolidasi', $konsolidasi);
    }

    /**
     * Update the specified Konsolidasi in storage.
     */
    public function update($id, UpdateKonsolidasiRequest $request)
    {
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            Flash::error('Konsolidasi not found');

            return redirect(route('konsolidasis.index'));
        }

        $konsolidasi = $this->konsolidasiRepository->update($request->all(), $id);

        Flash::success('Konsolidasi updated successfully.');

        return redirect(route('konsolidasis.index'));
    }

    /**
     * Remove the specified Konsolidasi from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            Flash::error('Konsolidasi not found');

            return redirect(route('konsolidasis.index'));
        }

        $this->konsolidasiRepository->delete($id);

        Flash::success('Konsolidasi deleted successfully.');

        return redirect(route('konsolidasis.index'));
    }
}
