<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBupKonsesiRequest;
use App\Http\Requests\UpdateBupKonsesiRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BupKonsesiRepository;
use Illuminate\Http\Request;
use Flash;

class BupKonsesiController extends AppBaseController
{
    /** @var BupKonsesiRepository $bupKonsesiRepository*/
    private $bupKonsesiRepository;

    public function __construct(BupKonsesiRepository $bupKonsesiRepo)
    {
        $this->bupKonsesiRepository = $bupKonsesiRepo;
    }

    /**
     * Display a listing of the BupKonsesi.
     */
    public function index(Request $request)
    {
        $bupKonsesis = $this->bupKonsesiRepository->paginate(10);

        return view('bup_konsesis.index')
            ->with('bupKonsesis', $bupKonsesis);
    }

    /**
     * Show the form for creating a new BupKonsesi.
     */
    public function create()
    {
        return view('bup_konsesis.create');
    }

    /**
     * Store a newly created BupKonsesi in storage.
     */
    public function store(CreateBupKonsesiRequest $request)
    {
        $input = $request->all();

        $bupKonsesi = $this->bupKonsesiRepository->create($input);

        Flash::success('Bup Konsesi saved successfully.');

        return redirect(route('bupKonsesis.index'));
    }

    /**
     * Display the specified BupKonsesi.
     */
    public function show($id)
    {
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            Flash::error('Bup Konsesi not found');

            return redirect(route('bupKonsesis.index'));
        }

        return view('bup_konsesis.show')->with('bupKonsesi', $bupKonsesi);
    }

    /**
     * Show the form for editing the specified BupKonsesi.
     */
    public function edit($id)
    {
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            Flash::error('Bup Konsesi not found');

            return redirect(route('bupKonsesis.index'));
        }

        return view('bup_konsesis.edit')->with('bupKonsesi', $bupKonsesi);
    }

    /**
     * Update the specified BupKonsesi in storage.
     */
    public function update($id, UpdateBupKonsesiRequest $request)
    {
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            Flash::error('Bup Konsesi not found');

            return redirect(route('bupKonsesis.index'));
        }

        $bupKonsesi = $this->bupKonsesiRepository->update($request->all(), $id);

        Flash::success('Bup Konsesi updated successfully.');

        return redirect(route('bupKonsesis.index'));
    }

    /**
     * Remove the specified BupKonsesi from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            Flash::error('Bup Konsesi not found');

            return redirect(route('bupKonsesis.index'));
        }

        $this->bupKonsesiRepository->delete($id);

        Flash::success('Bup Konsesi deleted successfully.');

        return redirect(route('bupKonsesis.index'));
    }
}
