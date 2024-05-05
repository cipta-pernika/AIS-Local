<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateImptPenggunaanAlatAPIRequest;
use App\Http\Requests\API\UpdateImptPenggunaanAlatAPIRequest;
use App\Models\ImptPenggunaanAlat;
use App\Repositories\ImptPenggunaanAlatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ImptPenggunaanAlatAPIController
 */
class ImptPenggunaanAlatAPIController extends AppBaseController
{
    private ImptPenggunaanAlatRepository $imptPenggunaanAlatRepository;

    public function __construct(ImptPenggunaanAlatRepository $imptPenggunaanAlatRepo)
    {
        $this->imptPenggunaanAlatRepository = $imptPenggunaanAlatRepo;
    }

    /**
     * Display a listing of the ImptPenggunaanAlats.
     * GET|HEAD /impt-penggunaan-alats
     */
    public function index(Request $request): JsonResponse
    {
        $imptPenggunaanAlats = $this->imptPenggunaanAlatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($imptPenggunaanAlats->toArray(), 'Impt Penggunaan Alats retrieved successfully');
    }

    /**
     * Store a newly created ImptPenggunaanAlat in storage.
     * POST /impt-penggunaan-alats
     */
    public function store(CreateImptPenggunaanAlatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->create($input);

        return $this->sendResponse($imptPenggunaanAlat->toArray(), 'Impt Penggunaan Alat saved successfully');
    }

    /**
     * Display the specified ImptPenggunaanAlat.
     * GET|HEAD /impt-penggunaan-alats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ImptPenggunaanAlat $imptPenggunaanAlat */
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            return $this->sendError('Impt Penggunaan Alat not found');
        }

        return $this->sendResponse($imptPenggunaanAlat->toArray(), 'Impt Penggunaan Alat retrieved successfully');
    }

    /**
     * Update the specified ImptPenggunaanAlat in storage.
     * PUT/PATCH /impt-penggunaan-alats/{id}
     */
    public function update($id, UpdateImptPenggunaanAlatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ImptPenggunaanAlat $imptPenggunaanAlat */
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            return $this->sendError('Impt Penggunaan Alat not found');
        }

        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->update($input, $id);

        return $this->sendResponse($imptPenggunaanAlat->toArray(), 'ImptPenggunaanAlat updated successfully');
    }

    /**
     * Remove the specified ImptPenggunaanAlat from storage.
     * DELETE /impt-penggunaan-alats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ImptPenggunaanAlat $imptPenggunaanAlat */
        $imptPenggunaanAlat = $this->imptPenggunaanAlatRepository->find($id);

        if (empty($imptPenggunaanAlat)) {
            return $this->sendError('Impt Penggunaan Alat not found');
        }

        $imptPenggunaanAlat->delete();

        return $this->sendSuccess('Impt Penggunaan Alat deleted successfully');
    }
}
