<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaBarangAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaBarangAPIRequest;
use App\Models\PNBPJasaBarang;
use App\Repositories\PNBPJasaBarangRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaBarangAPIController
 */
class PNBPJasaBarangAPIController extends AppBaseController
{
    private PNBPJasaBarangRepository $pNBPJasaBarangRepository;

    public function __construct(PNBPJasaBarangRepository $pNBPJasaBarangRepo)
    {
        $this->pNBPJasaBarangRepository = $pNBPJasaBarangRepo;
    }

    /**
     * Display a listing of the PNBPJasaBarangs.
     * GET|HEAD /p-n-b-p-jasa-barangs
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaBarangs = $this->pNBPJasaBarangRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaBarangs->toArray(), 'P N B P Jasa Barangs retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaBarang in storage.
     * POST /p-n-b-p-jasa-barangs
     */
    public function store(CreatePNBPJasaBarangAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->create($input);

        return $this->sendResponse($pNBPJasaBarang->toArray(), 'P N B P Jasa Barang saved successfully');
    }

    /**
     * Display the specified PNBPJasaBarang.
     * GET|HEAD /p-n-b-p-jasa-barangs/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaBarang $pNBPJasaBarang */
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            return $this->sendError('P N B P Jasa Barang not found');
        }

        return $this->sendResponse($pNBPJasaBarang->toArray(), 'P N B P Jasa Barang retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaBarang in storage.
     * PUT/PATCH /p-n-b-p-jasa-barangs/{id}
     */
    public function update($id, UpdatePNBPJasaBarangAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaBarang $pNBPJasaBarang */
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            return $this->sendError('P N B P Jasa Barang not found');
        }

        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaBarang->toArray(), 'PNBPJasaBarang updated successfully');
    }

    /**
     * Remove the specified PNBPJasaBarang from storage.
     * DELETE /p-n-b-p-jasa-barangs/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaBarang $pNBPJasaBarang */
        $pNBPJasaBarang = $this->pNBPJasaBarangRepository->find($id);

        if (empty($pNBPJasaBarang)) {
            return $this->sendError('P N B P Jasa Barang not found');
        }

        $pNBPJasaBarang->delete();

        return $this->sendSuccess('P N B P Jasa Barang deleted successfully');
    }
}
