<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateImptPenggunaanAlatBongkarMuatAPIRequest;
use App\Http\Requests\API\UpdateImptPenggunaanAlatBongkarMuatAPIRequest;
use App\Models\ImptPenggunaanAlatBongkarMuat;
use App\Repositories\ImptPenggunaanAlatBongkarMuatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ImptPenggunaanAlatBongkarMuatAPIController
 */
class ImptPenggunaanAlatBongkarMuatAPIController extends AppBaseController
{
    private ImptPenggunaanAlatBongkarMuatRepository $imptPenggunaanAlatBongkarMuatRepository;

    public function __construct(ImptPenggunaanAlatBongkarMuatRepository $imptPenggunaanAlatBongkarMuatRepo)
    {
        $this->imptPenggunaanAlatBongkarMuatRepository = $imptPenggunaanAlatBongkarMuatRepo;
    }

    /**
     * Display a listing of the ImptPenggunaanAlatBongkarMuats.
     * GET|HEAD /impt-penggunaan-alat-bongkar-muats
     */
    public function index(Request $request): JsonResponse
    {
        $imptPenggunaanAlatBongkarMuats = $this->imptPenggunaanAlatBongkarMuatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($imptPenggunaanAlatBongkarMuats->toArray(), 'Impt Penggunaan Alat Bongkar Muats retrieved successfully');
    }

    /**
     * Store a newly created ImptPenggunaanAlatBongkarMuat in storage.
     * POST /impt-penggunaan-alat-bongkar-muats
     */
    public function store(CreateImptPenggunaanAlatBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->create($input);

        return $this->sendResponse($imptPenggunaanAlatBongkarMuat->toArray(), 'Impt Penggunaan Alat Bongkar Muat saved successfully');
    }

    /**
     * Display the specified ImptPenggunaanAlatBongkarMuat.
     * GET|HEAD /impt-penggunaan-alat-bongkar-muats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ImptPenggunaanAlatBongkarMuat $imptPenggunaanAlatBongkarMuat */
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            return $this->sendError('Impt Penggunaan Alat Bongkar Muat not found');
        }

        return $this->sendResponse($imptPenggunaanAlatBongkarMuat->toArray(), 'Impt Penggunaan Alat Bongkar Muat retrieved successfully');
    }

    /**
     * Update the specified ImptPenggunaanAlatBongkarMuat in storage.
     * PUT/PATCH /impt-penggunaan-alat-bongkar-muats/{id}
     */
    public function update($id, UpdateImptPenggunaanAlatBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ImptPenggunaanAlatBongkarMuat $imptPenggunaanAlatBongkarMuat */
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            return $this->sendError('Impt Penggunaan Alat Bongkar Muat not found');
        }

        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->update($input, $id);

        return $this->sendResponse($imptPenggunaanAlatBongkarMuat->toArray(), 'ImptPenggunaanAlatBongkarMuat updated successfully');
    }

    /**
     * Remove the specified ImptPenggunaanAlatBongkarMuat from storage.
     * DELETE /impt-penggunaan-alat-bongkar-muats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ImptPenggunaanAlatBongkarMuat $imptPenggunaanAlatBongkarMuat */
        $imptPenggunaanAlatBongkarMuat = $this->imptPenggunaanAlatBongkarMuatRepository->find($id);

        if (empty($imptPenggunaanAlatBongkarMuat)) {
            return $this->sendError('Impt Penggunaan Alat Bongkar Muat not found');
        }

        $imptPenggunaanAlatBongkarMuat->delete();

        return $this->sendSuccess('Impt Penggunaan Alat Bongkar Muat deleted successfully');
    }
}
