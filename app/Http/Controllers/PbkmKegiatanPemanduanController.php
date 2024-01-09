<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePbkmKegiatanPemanduanRequest;
use App\Http\Requests\UpdatePbkmKegiatanPemanduanRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PbkmKegiatanPemanduanRepository;
use Illuminate\Http\Request;
use Flash;

class PbkmKegiatanPemanduanController extends AppBaseController
{
    /** @var PbkmKegiatanPemanduanRepository $pbkmKegiatanPemanduanRepository*/
    private $pbkmKegiatanPemanduanRepository;

    public function __construct(PbkmKegiatanPemanduanRepository $pbkmKegiatanPemanduanRepo)
    {
        $this->pbkmKegiatanPemanduanRepository = $pbkmKegiatanPemanduanRepo;
    }

    /**
     * Display a listing of the PbkmKegiatanPemanduan.
     */
    public function index(Request $request)
    {
        $pbkmKegiatanPemanduans = $this->pbkmKegiatanPemanduanRepository->paginate(10);

        return view('pbkm_kegiatan_pemanduans.index')
            ->with('pbkmKegiatanPemanduans', $pbkmKegiatanPemanduans);
    }

    /**
     * Show the form for creating a new PbkmKegiatanPemanduan.
     */
    public function create()
    {
        return view('pbkm_kegiatan_pemanduans.create');
    }

    /**
     * Store a newly created PbkmKegiatanPemanduan in storage.
     */
    public function store(CreatePbkmKegiatanPemanduanRequest $request)
    {
        $input = $request->all();

        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->create($input);

        Flash::success('Pbkm Kegiatan Pemanduan saved successfully.');

        return redirect(route('pbkmKegiatanPemanduans.index'));
    }

    /**
     * Display the specified PbkmKegiatanPemanduan.
     */
    public function show($id)
    {
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            Flash::error('Pbkm Kegiatan Pemanduan not found');

            return redirect(route('pbkmKegiatanPemanduans.index'));
        }

        return view('pbkm_kegiatan_pemanduans.show')->with('pbkmKegiatanPemanduan', $pbkmKegiatanPemanduan);
    }

    /**
     * Show the form for editing the specified PbkmKegiatanPemanduan.
     */
    public function edit($id)
    {
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            Flash::error('Pbkm Kegiatan Pemanduan not found');

            return redirect(route('pbkmKegiatanPemanduans.index'));
        }

        return view('pbkm_kegiatan_pemanduans.edit')->with('pbkmKegiatanPemanduan', $pbkmKegiatanPemanduan);
    }

    /**
     * Update the specified PbkmKegiatanPemanduan in storage.
     */
    public function update($id, UpdatePbkmKegiatanPemanduanRequest $request)
    {
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            Flash::error('Pbkm Kegiatan Pemanduan not found');

            return redirect(route('pbkmKegiatanPemanduans.index'));
        }

        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->update($request->all(), $id);

        Flash::success('Pbkm Kegiatan Pemanduan updated successfully.');

        return redirect(route('pbkmKegiatanPemanduans.index'));
    }

    /**
     * Remove the specified PbkmKegiatanPemanduan from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            Flash::error('Pbkm Kegiatan Pemanduan not found');

            return redirect(route('pbkmKegiatanPemanduans.index'));
        }

        $this->pbkmKegiatanPemanduanRepository->delete($id);

        Flash::success('Pbkm Kegiatan Pemanduan deleted successfully.');

        return redirect(route('pbkmKegiatanPemanduans.index'));
    }
}
