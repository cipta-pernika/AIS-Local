<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInaportnetBongkarMuatAPIRequest;
use App\Http\Requests\API\UpdateInaportnetBongkarMuatAPIRequest;
use App\Models\InaportnetBongkarMuat;
use App\Repositories\InaportnetBongkarMuatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class InaportnetBongkarMuatAPIController
 */
class InaportnetBongkarMuatAPIController extends AppBaseController
{
    private InaportnetBongkarMuatRepository $inaportnetBongkarMuatRepository;

    public function __construct(InaportnetBongkarMuatRepository $inaportnetBongkarMuatRepo)
    {
        $this->inaportnetBongkarMuatRepository = $inaportnetBongkarMuatRepo;
    }

    /**
     * Display a listing of the InaportnetBongkarMuats.
     * GET|HEAD /inaportnet-bongkar-muats
     */
    public function index(Request $request): JsonResponse
    {
        $inaportnetBongkarMuats = $this->inaportnetBongkarMuatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($inaportnetBongkarMuats->toArray(), 'Inaportnet Bongkar Muats retrieved successfully');
    }

    /**
     * Store a newly created InaportnetBongkarMuat in storage.
     * POST /inaportnet-bongkar-muats
     */
    public function store(CreateInaportnetBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->create($input);

        return $this->sendResponse($inaportnetBongkarMuat->toArray(), 'Inaportnet Bongkar Muat saved successfully');
    }

    /**
     * Display the specified InaportnetBongkarMuat.
     * GET|HEAD /inaportnet-bongkar-muats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var InaportnetBongkarMuat $inaportnetBongkarMuat */
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            return $this->sendError('Inaportnet Bongkar Muat not found');
        }

        return $this->sendResponse($inaportnetBongkarMuat->toArray(), 'Inaportnet Bongkar Muat retrieved successfully');
    }

    /**
     * Update the specified InaportnetBongkarMuat in storage.
     * PUT/PATCH /inaportnet-bongkar-muats/{id}
     */
    public function update($id, UpdateInaportnetBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var InaportnetBongkarMuat $inaportnetBongkarMuat */
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            return $this->sendError('Inaportnet Bongkar Muat not found');
        }

        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->update($input, $id);

        return $this->sendResponse($inaportnetBongkarMuat->toArray(), 'InaportnetBongkarMuat updated successfully');
    }

    /**
     * Remove the specified InaportnetBongkarMuat from storage.
     * DELETE /inaportnet-bongkar-muats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var InaportnetBongkarMuat $inaportnetBongkarMuat */
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            return $this->sendError('Inaportnet Bongkar Muat not found');
        }

        $inaportnetBongkarMuat->delete();

        return $this->sendSuccess('Inaportnet Bongkar Muat deleted successfully');
    }
}
