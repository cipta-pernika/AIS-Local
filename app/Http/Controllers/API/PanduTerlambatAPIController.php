<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePanduTerlambatAPIRequest;
use App\Http\Requests\API\UpdatePanduTerlambatAPIRequest;
use App\Models\PanduTerlambat;
use App\Repositories\PanduTerlambatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PanduTerlambatAPIController
 */
class PanduTerlambatAPIController extends AppBaseController
{
    private PanduTerlambatRepository $panduTerlambatRepository;

    public function __construct(PanduTerlambatRepository $panduTerlambatRepo)
    {
        $this->panduTerlambatRepository = $panduTerlambatRepo;
    }

    /**
     * Display a listing of the PanduTerlambats.
     * GET|HEAD /pandu-terlambats
     */
    public function index(Request $request): JsonResponse
    {
        $panduTerlambats = $this->panduTerlambatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($panduTerlambats->toArray(), 'Pandu Terlambats retrieved successfully');
    }

    /**
     * Store a newly created PanduTerlambat in storage.
     * POST /pandu-terlambats
     */
    public function store(CreatePanduTerlambatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $panduTerlambat = $this->panduTerlambatRepository->create($input);

        return $this->sendResponse($panduTerlambat->toArray(), 'Pandu Terlambat saved successfully');
    }

    /**
     * Display the specified PanduTerlambat.
     * GET|HEAD /pandu-terlambats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PanduTerlambat $panduTerlambat */
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            return $this->sendError('Pandu Terlambat not found');
        }

        return $this->sendResponse($panduTerlambat->toArray(), 'Pandu Terlambat retrieved successfully');
    }

    /**
     * Update the specified PanduTerlambat in storage.
     * PUT/PATCH /pandu-terlambats/{id}
     */
    public function update($id, UpdatePanduTerlambatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PanduTerlambat $panduTerlambat */
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            return $this->sendError('Pandu Terlambat not found');
        }

        $panduTerlambat = $this->panduTerlambatRepository->update($input, $id);

        return $this->sendResponse($panduTerlambat->toArray(), 'PanduTerlambat updated successfully');
    }

    /**
     * Remove the specified PanduTerlambat from storage.
     * DELETE /pandu-terlambats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PanduTerlambat $panduTerlambat */
        $panduTerlambat = $this->panduTerlambatRepository->find($id);

        if (empty($panduTerlambat)) {
            return $this->sendError('Pandu Terlambat not found');
        }

        $panduTerlambat->delete();

        return $this->sendSuccess('Pandu Terlambat deleted successfully');
    }
}
