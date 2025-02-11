<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePanduTidakTerjadwalAPIRequest;
use App\Http\Requests\API\UpdatePanduTidakTerjadwalAPIRequest;
use App\Models\PanduTidakTerjadwal;
use App\Repositories\PanduTidakTerjadwalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PanduTidakTerjadwalAPIController
 */
class PanduTidakTerjadwalAPIController extends AppBaseController
{
    private PanduTidakTerjadwalRepository $panduTidakTerjadwalRepository;

    public function __construct(PanduTidakTerjadwalRepository $panduTidakTerjadwalRepo)
    {
        $this->panduTidakTerjadwalRepository = $panduTidakTerjadwalRepo;
    }

    /**
     * Display a listing of the PanduTidakTerjadwals.
     * GET|HEAD /pandu-tidak-terjadwals
     */
    public function index(Request $request): JsonResponse
    {
        $panduTidakTerjadwals = $this->panduTidakTerjadwalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($panduTidakTerjadwals->toArray(), 'Pandu Tidak Terjadwals retrieved successfully');
    }

    /**
     * Store a newly created PanduTidakTerjadwal in storage.
     * POST /pandu-tidak-terjadwals
     */
    public function store(CreatePanduTidakTerjadwalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->create($input);

        return $this->sendResponse($panduTidakTerjadwal->toArray(), 'Pandu Tidak Terjadwal saved successfully');
    }

    /**
     * Display the specified PanduTidakTerjadwal.
     * GET|HEAD /pandu-tidak-terjadwals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PanduTidakTerjadwal $panduTidakTerjadwal */
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            return $this->sendError('Pandu Tidak Terjadwal not found');
        }

        return $this->sendResponse($panduTidakTerjadwal->toArray(), 'Pandu Tidak Terjadwal retrieved successfully');
    }

    /**
     * Update the specified PanduTidakTerjadwal in storage.
     * PUT/PATCH /pandu-tidak-terjadwals/{id}
     */
    public function update($id, UpdatePanduTidakTerjadwalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PanduTidakTerjadwal $panduTidakTerjadwal */
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            return $this->sendError('Pandu Tidak Terjadwal not found');
        }

        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->update($input, $id);

        return $this->sendResponse($panduTidakTerjadwal->toArray(), 'PanduTidakTerjadwal updated successfully');
    }

    /**
     * Remove the specified PanduTidakTerjadwal from storage.
     * DELETE /pandu-tidak-terjadwals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PanduTidakTerjadwal $panduTidakTerjadwal */
        $panduTidakTerjadwal = $this->panduTidakTerjadwalRepository->find($id);

        if (empty($panduTidakTerjadwal)) {
            return $this->sendError('Pandu Tidak Terjadwal not found');
        }

        $panduTidakTerjadwal->delete();

        return $this->sendSuccess('Pandu Tidak Terjadwal deleted successfully');
    }
}
