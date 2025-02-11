<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImptBongkarMuatRequest;
use App\Http\Requests\UpdateImptBongkarMuatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ImptBongkarMuatRepository;
use Illuminate\Http\Request;
use Flash;

class ImptBongkarMuatController extends AppBaseController
{
    /** @var ImptBongkarMuatRepository $imptBongkarMuatRepository*/
    private $imptBongkarMuatRepository;

    public function __construct(ImptBongkarMuatRepository $imptBongkarMuatRepo)
    {
        $this->imptBongkarMuatRepository = $imptBongkarMuatRepo;
    }

    /**
     * Display a listing of the ImptBongkarMuat.
     */
    public function index(Request $request)
    {
        $imptBongkarMuats = $this->imptBongkarMuatRepository->paginate(10);

        return view('impt_bongkar_muats.index')
            ->with('imptBongkarMuats', $imptBongkarMuats);
    }

    /**
     * Show the form for creating a new ImptBongkarMuat.
     */
    public function create()
    {
        return view('impt_bongkar_muats.create');
    }

    /**
     * Store a newly created ImptBongkarMuat in storage.
     */
    public function store(CreateImptBongkarMuatRequest $request)
    {
        $input = $request->all();

        $imptBongkarMuat = $this->imptBongkarMuatRepository->create($input);

        Flash::success('Impt Bongkar Muat saved successfully.');

        return redirect(route('imptBongkarMuats.index'));
    }

    /**
     * Display the specified ImptBongkarMuat.
     */
    public function show($id)
    {
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            Flash::error('Impt Bongkar Muat not found');

            return redirect(route('imptBongkarMuats.index'));
        }

        return view('impt_bongkar_muats.show')->with('imptBongkarMuat', $imptBongkarMuat);
    }

    /**
     * Show the form for editing the specified ImptBongkarMuat.
     */
    public function edit($id)
    {
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            Flash::error('Impt Bongkar Muat not found');

            return redirect(route('imptBongkarMuats.index'));
        }

        return view('impt_bongkar_muats.edit')->with('imptBongkarMuat', $imptBongkarMuat);
    }

    /**
     * Update the specified ImptBongkarMuat in storage.
     */
    public function update($id, UpdateImptBongkarMuatRequest $request)
    {
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            Flash::error('Impt Bongkar Muat not found');

            return redirect(route('imptBongkarMuats.index'));
        }

        $imptBongkarMuat = $this->imptBongkarMuatRepository->update($request->all(), $id);

        Flash::success('Impt Bongkar Muat updated successfully.');

        return redirect(route('imptBongkarMuats.index'));
    }

    /**
     * Remove the specified ImptBongkarMuat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            Flash::error('Impt Bongkar Muat not found');

            return redirect(route('imptBongkarMuats.index'));
        }

        $this->imptBongkarMuatRepository->delete($id);

        Flash::success('Impt Bongkar Muat deleted successfully.');

        return redirect(route('imptBongkarMuats.index'));
    }
}
