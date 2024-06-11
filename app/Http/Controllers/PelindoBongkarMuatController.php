<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePelindoBongkarMuatRequest;
use App\Http\Requests\UpdatePelindoBongkarMuatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PelindoBongkarMuatRepository;
use Illuminate\Http\Request;
use Flash;

class PelindoBongkarMuatController extends AppBaseController
{
    /** @var PelindoBongkarMuatRepository $pelindoBongkarMuatRepository*/
    private $pelindoBongkarMuatRepository;

    public function __construct(PelindoBongkarMuatRepository $pelindoBongkarMuatRepo)
    {
        $this->pelindoBongkarMuatRepository = $pelindoBongkarMuatRepo;
    }

    /**
     * Display a listing of the PelindoBongkarMuat.
     */
    public function index(Request $request)
    {
        $pelindoBongkarMuats = $this->pelindoBongkarMuatRepository->paginate(10);

        return view('pelindo_bongkar_muats.index')
            ->with('pelindoBongkarMuats', $pelindoBongkarMuats);
    }

    /**
     * Show the form for creating a new PelindoBongkarMuat.
     */
    public function create()
    {
        return view('pelindo_bongkar_muats.create');
    }

    /**
     * Store a newly created PelindoBongkarMuat in storage.
     */
    public function store(CreatePelindoBongkarMuatRequest $request)
    {
        $input = $request->all();

        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->create($input);

        Flash::success('Pelindo Bongkar Muat saved successfully.');

        return redirect(route('pelindoBongkarMuats.index'));
    }

    /**
     * Display the specified PelindoBongkarMuat.
     */
    public function show($id)
    {
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            Flash::error('Pelindo Bongkar Muat not found');

            return redirect(route('pelindoBongkarMuats.index'));
        }

        return view('pelindo_bongkar_muats.show')->with('pelindoBongkarMuat', $pelindoBongkarMuat);
    }

    /**
     * Show the form for editing the specified PelindoBongkarMuat.
     */
    public function edit($id)
    {
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            Flash::error('Pelindo Bongkar Muat not found');

            return redirect(route('pelindoBongkarMuats.index'));
        }

        return view('pelindo_bongkar_muats.edit')->with('pelindoBongkarMuat', $pelindoBongkarMuat);
    }

    /**
     * Update the specified PelindoBongkarMuat in storage.
     */
    public function update($id, UpdatePelindoBongkarMuatRequest $request)
    {
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            Flash::error('Pelindo Bongkar Muat not found');

            return redirect(route('pelindoBongkarMuats.index'));
        }

        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->update($request->all(), $id);

        Flash::success('Pelindo Bongkar Muat updated successfully.');

        return redirect(route('pelindoBongkarMuats.index'));
    }

    /**
     * Remove the specified PelindoBongkarMuat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            Flash::error('Pelindo Bongkar Muat not found');

            return redirect(route('pelindoBongkarMuats.index'));
        }

        $this->pelindoBongkarMuatRepository->delete($id);

        Flash::success('Pelindo Bongkar Muat deleted successfully.');

        return redirect(route('pelindoBongkarMuats.index'));
    }
}
