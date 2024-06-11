<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateImptBongkarMuatAPIRequest;
use App\Http\Requests\API\UpdateImptBongkarMuatAPIRequest;
use App\Models\ImptBongkarMuat;
use App\Repositories\ImptBongkarMuatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ImptBongkarMuatAPIController
 */
class ImptBongkarMuatAPIController extends AppBaseController
{
    private ImptBongkarMuatRepository $imptBongkarMuatRepository;

    public function __construct(ImptBongkarMuatRepository $imptBongkarMuatRepo)
    {
        $this->imptBongkarMuatRepository = $imptBongkarMuatRepo;
    }

    /**
     * Display a listing of the ImptBongkarMuats.
     * GET|HEAD /impt-bongkar-muats
     */
    public function index(Request $request): JsonResponse
    {
        $imptBongkarMuats = $this->imptBongkarMuatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($imptBongkarMuats->toArray(), 'Impt Bongkar Muats retrieved successfully');
    }

    /**
     * Store a newly created ImptBongkarMuat in storage.
     * POST /impt-bongkar-muats
     */
    public function store(CreateImptBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $imptBongkarMuat = $this->imptBongkarMuatRepository->create($input);

        return $this->sendResponse($imptBongkarMuat->toArray(), 'Impt Bongkar Muat saved successfully');
    }

    /**
     * Display the specified ImptBongkarMuat.
     * GET|HEAD /impt-bongkar-muats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ImptBongkarMuat $imptBongkarMuat */
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            return $this->sendError('Impt Bongkar Muat not found');
        }

        return $this->sendResponse($imptBongkarMuat->toArray(), 'Impt Bongkar Muat retrieved successfully');
    }

    /**
     * Update the specified ImptBongkarMuat in storage.
     * PUT/PATCH /impt-bongkar-muats/{id}
     */
    public function update($id, UpdateImptBongkarMuatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ImptBongkarMuat $imptBongkarMuat */
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            return $this->sendError('Impt Bongkar Muat not found');
        }

        $imptBongkarMuat = $this->imptBongkarMuatRepository->update($input, $id);

        return $this->sendResponse($imptBongkarMuat->toArray(), 'ImptBongkarMuat updated successfully');
    }

    /**
     * Remove the specified ImptBongkarMuat from storage.
     * DELETE /impt-bongkar-muats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ImptBongkarMuat $imptBongkarMuat */
        $imptBongkarMuat = $this->imptBongkarMuatRepository->find($id);

        if (empty($imptBongkarMuat)) {
            return $this->sendError('Impt Bongkar Muat not found');
        }

        $imptBongkarMuat->delete();

        return $this->sendSuccess('Impt Bongkar Muat deleted successfully');
    }
}
