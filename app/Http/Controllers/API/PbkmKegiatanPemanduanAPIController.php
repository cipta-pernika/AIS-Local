<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePbkmKegiatanPemanduanAPIRequest;
use App\Http\Requests\API\UpdatePbkmKegiatanPemanduanAPIRequest;
use App\Models\PbkmKegiatanPemanduan;
use App\Repositories\PbkmKegiatanPemanduanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PbkmKegiatanPemanduanAPIController
 */
class PbkmKegiatanPemanduanAPIController extends AppBaseController
{
    private PbkmKegiatanPemanduanRepository $pbkmKegiatanPemanduanRepository;

    public function __construct(PbkmKegiatanPemanduanRepository $pbkmKegiatanPemanduanRepo)
    {
        $this->pbkmKegiatanPemanduanRepository = $pbkmKegiatanPemanduanRepo;
    }

    /**
     * Display a listing of the PbkmKegiatanPemanduans.
     * GET|HEAD /pbkm-kegiatan-pemanduans
     */
    public function index(Request $request): JsonResponse
    {
        $pbkmKegiatanPemanduans = $this->pbkmKegiatanPemanduanRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pbkmKegiatanPemanduans->toArray(), 'Pbkm Kegiatan Pemanduans retrieved successfully');
    }

    /**
     * Store a newly created PbkmKegiatanPemanduan in storage.
     * POST /pbkm-kegiatan-pemanduans
     */
    public function store(CreatePbkmKegiatanPemanduanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->create($input);

        return $this->sendResponse($pbkmKegiatanPemanduan->toArray(), 'Pbkm Kegiatan Pemanduan saved successfully');
    }

    /**
     * Display the specified PbkmKegiatanPemanduan.
     * GET|HEAD /pbkm-kegiatan-pemanduans/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PbkmKegiatanPemanduan $pbkmKegiatanPemanduan */
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            return $this->sendError('Pbkm Kegiatan Pemanduan not found');
        }

        return $this->sendResponse($pbkmKegiatanPemanduan->toArray(), 'Pbkm Kegiatan Pemanduan retrieved successfully');
    }

    /**
     * Update the specified PbkmKegiatanPemanduan in storage.
     * PUT/PATCH /pbkm-kegiatan-pemanduans/{id}
     */
    public function update($id, UpdatePbkmKegiatanPemanduanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PbkmKegiatanPemanduan $pbkmKegiatanPemanduan */
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            return $this->sendError('Pbkm Kegiatan Pemanduan not found');
        }

        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->update($input, $id);

        return $this->sendResponse($pbkmKegiatanPemanduan->toArray(), 'PbkmKegiatanPemanduan updated successfully');
    }

    /**
     * Remove the specified PbkmKegiatanPemanduan from storage.
     * DELETE /pbkm-kegiatan-pemanduans/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PbkmKegiatanPemanduan $pbkmKegiatanPemanduan */
        $pbkmKegiatanPemanduan = $this->pbkmKegiatanPemanduanRepository->find($id);

        if (empty($pbkmKegiatanPemanduan)) {
            return $this->sendError('Pbkm Kegiatan Pemanduan not found');
        }

        $pbkmKegiatanPemanduan->delete();

        return $this->sendSuccess('Pbkm Kegiatan Pemanduan deleted successfully');
    }
}
