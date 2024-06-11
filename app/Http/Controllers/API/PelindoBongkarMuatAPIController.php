<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePelindoBongkarMuatAPIRequest;
use App\Http\Requests\API\UpdatePelindoBongkarMuatAPIRequest;
use App\Models\PelindoBongkarMuat;
use App\Repositories\PelindoBongkarMuatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PelindoBongkarMuatAPIController
 */
class PelindoBongkarMuatAPIController extends AppBaseController
{
    private PelindoBongkarMuatRepository $pelindoBongkarMuatRepository;

    public function __construct(PelindoBongkarMuatRepository $pelindoBongkarMuatRepo)
    {
        $this->pelindoBongkarMuatRepository = $pelindoBongkarMuatRepo;
    }

    /**
     * Display a listing of the PelindoBongkarMuats.
     * GET|HEAD /pelindo-bongkar-muats
     */
    public function index(Request $request): JsonResponse
    {
        $pelindoBongkarMuats = $this->pelindoBongkarMuatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pelindoBongkarMuats->toArray(), 'Pelindo Bongkar Muats retrieved successfully');
    }

    /**
     * Store a newly created PelindoBongkarMuat in storage.
     * POST /pelindo-bongkar-muats
     */
    public function store(CreatePelindoBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->create($input);

        return $this->sendResponse($pelindoBongkarMuat->toArray(), 'Pelindo Bongkar Muat saved successfully');
    }

    /**
     * Display the specified PelindoBongkarMuat.
     * GET|HEAD /pelindo-bongkar-muats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PelindoBongkarMuat $pelindoBongkarMuat */
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            return $this->sendError('Pelindo Bongkar Muat not found');
        }

        return $this->sendResponse($pelindoBongkarMuat->toArray(), 'Pelindo Bongkar Muat retrieved successfully');
    }

    /**
     * Update the specified PelindoBongkarMuat in storage.
     * PUT/PATCH /pelindo-bongkar-muats/{id}
     */
    public function update($id, UpdatePelindoBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PelindoBongkarMuat $pelindoBongkarMuat */
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            return $this->sendError('Pelindo Bongkar Muat not found');
        }

        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->update($input, $id);

        return $this->sendResponse($pelindoBongkarMuat->toArray(), 'PelindoBongkarMuat updated successfully');
    }

    /**
     * Remove the specified PelindoBongkarMuat from storage.
     * DELETE /pelindo-bongkar-muats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PelindoBongkarMuat $pelindoBongkarMuat */
        $pelindoBongkarMuat = $this->pelindoBongkarMuatRepository->find($id);

        if (empty($pelindoBongkarMuat)) {
            return $this->sendError('Pelindo Bongkar Muat not found');
        }

        $pelindoBongkarMuat->delete();

        return $this->sendSuccess('Pelindo Bongkar Muat deleted successfully');
    }
}
