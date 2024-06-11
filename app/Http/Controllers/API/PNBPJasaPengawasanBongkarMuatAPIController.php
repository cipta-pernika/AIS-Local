<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaPengawasanBongkarMuatAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaPengawasanBongkarMuatAPIRequest;
use App\Models\PNBPJasaPengawasanBongkarMuat;
use App\Repositories\PNBPJasaPengawasanBongkarMuatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaPengawasanBongkarMuatAPIController
 */
class PNBPJasaPengawasanBongkarMuatAPIController extends AppBaseController
{
    private PNBPJasaPengawasanBongkarMuatRepository $pNBPJasaPengawasanBongkarMuatRepository;

    public function __construct(PNBPJasaPengawasanBongkarMuatRepository $pNBPJasaPengawasanBongkarMuatRepo)
    {
        $this->pNBPJasaPengawasanBongkarMuatRepository = $pNBPJasaPengawasanBongkarMuatRepo;
    }

    /**
     * Display a listing of the PNBPJasaPengawasanBongkarMuats.
     * GET|HEAD /p-n-b-p-jasa-pengawasan-bongkar-muats
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaPengawasanBongkarMuats = $this->pNBPJasaPengawasanBongkarMuatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaPengawasanBongkarMuats->toArray(), 'P N B P Jasa Pengawasan Bongkar Muats retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaPengawasanBongkarMuat in storage.
     * POST /p-n-b-p-jasa-pengawasan-bongkar-muats
     */
    public function store(CreatePNBPJasaPengawasanBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->create($input);

        return $this->sendResponse($pNBPJasaPengawasanBongkarMuat->toArray(), 'P N B P Jasa Pengawasan Bongkar Muat saved successfully');
    }

    /**
     * Display the specified PNBPJasaPengawasanBongkarMuat.
     * GET|HEAD /p-n-b-p-jasa-pengawasan-bongkar-muats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaPengawasanBongkarMuat $pNBPJasaPengawasanBongkarMuat */
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            return $this->sendError('P N B P Jasa Pengawasan Bongkar Muat not found');
        }

        return $this->sendResponse($pNBPJasaPengawasanBongkarMuat->toArray(), 'P N B P Jasa Pengawasan Bongkar Muat retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaPengawasanBongkarMuat in storage.
     * PUT/PATCH /p-n-b-p-jasa-pengawasan-bongkar-muats/{id}
     */
    public function update($id, UpdatePNBPJasaPengawasanBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaPengawasanBongkarMuat $pNBPJasaPengawasanBongkarMuat */
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            return $this->sendError('P N B P Jasa Pengawasan Bongkar Muat not found');
        }

        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaPengawasanBongkarMuat->toArray(), 'PNBPJasaPengawasanBongkarMuat updated successfully');
    }

    /**
     * Remove the specified PNBPJasaPengawasanBongkarMuat from storage.
     * DELETE /p-n-b-p-jasa-pengawasan-bongkar-muats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaPengawasanBongkarMuat $pNBPJasaPengawasanBongkarMuat */
        $pNBPJasaPengawasanBongkarMuat = $this->pNBPJasaPengawasanBongkarMuatRepository->find($id);

        if (empty($pNBPJasaPengawasanBongkarMuat)) {
            return $this->sendError('P N B P Jasa Pengawasan Bongkar Muat not found');
        }

        $pNBPJasaPengawasanBongkarMuat->delete();

        return $this->sendSuccess('P N B P Jasa Pengawasan Bongkar Muat deleted successfully');
    }
}
