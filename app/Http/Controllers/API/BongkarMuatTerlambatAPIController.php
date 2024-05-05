<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBongkarMuatTerlambatAPIRequest;
use App\Http\Requests\API\UpdateBongkarMuatTerlambatAPIRequest;
use App\Models\BongkarMuatTerlambat;
use App\Repositories\BongkarMuatTerlambatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class BongkarMuatTerlambatAPIController
 */
class BongkarMuatTerlambatAPIController extends AppBaseController
{
    private BongkarMuatTerlambatRepository $bongkarMuatTerlambatRepository;

    public function __construct(BongkarMuatTerlambatRepository $bongkarMuatTerlambatRepo)
    {
        $this->bongkarMuatTerlambatRepository = $bongkarMuatTerlambatRepo;
    }

    /**
     * Display a listing of the BongkarMuatTerlambats.
     * GET|HEAD /bongkar-muat-terlambats
     */
    public function index(Request $request): JsonResponse
    {
        $bongkarMuatTerlambats = $this->bongkarMuatTerlambatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($bongkarMuatTerlambats->toArray(), 'Bongkar Muat Terlambats retrieved successfully');
    }

    /**
     * Store a newly created BongkarMuatTerlambat in storage.
     * POST /bongkar-muat-terlambats
     */
    public function store(CreateBongkarMuatTerlambatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->create($input);

        return $this->sendResponse($bongkarMuatTerlambat->toArray(), 'Bongkar Muat Terlambat saved successfully');
    }

    /**
     * Display the specified BongkarMuatTerlambat.
     * GET|HEAD /bongkar-muat-terlambats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var BongkarMuatTerlambat $bongkarMuatTerlambat */
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            return $this->sendError('Bongkar Muat Terlambat not found');
        }

        return $this->sendResponse($bongkarMuatTerlambat->toArray(), 'Bongkar Muat Terlambat retrieved successfully');
    }

    /**
     * Update the specified BongkarMuatTerlambat in storage.
     * PUT/PATCH /bongkar-muat-terlambats/{id}
     */
    public function update($id, UpdateBongkarMuatTerlambatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var BongkarMuatTerlambat $bongkarMuatTerlambat */
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            return $this->sendError('Bongkar Muat Terlambat not found');
        }

        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->update($input, $id);

        return $this->sendResponse($bongkarMuatTerlambat->toArray(), 'BongkarMuatTerlambat updated successfully');
    }

    /**
     * Remove the specified BongkarMuatTerlambat from storage.
     * DELETE /bongkar-muat-terlambats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var BongkarMuatTerlambat $bongkarMuatTerlambat */
        $bongkarMuatTerlambat = $this->bongkarMuatTerlambatRepository->find($id);

        if (empty($bongkarMuatTerlambat)) {
            return $this->sendError('Bongkar Muat Terlambat not found');
        }

        $bongkarMuatTerlambat->delete();

        return $this->sendSuccess('Bongkar Muat Terlambat deleted successfully');
    }
}
