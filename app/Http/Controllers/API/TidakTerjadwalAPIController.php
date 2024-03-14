<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTidakTerjadwalAPIRequest;
use App\Http\Requests\API\UpdateTidakTerjadwalAPIRequest;
use App\Models\TidakTerjadwal;
use App\Repositories\TidakTerjadwalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TidakTerjadwalAPIController
 */
class TidakTerjadwalAPIController extends AppBaseController
{
    private TidakTerjadwalRepository $tidakTerjadwalRepository;

    public function __construct(TidakTerjadwalRepository $tidakTerjadwalRepo)
    {
        $this->tidakTerjadwalRepository = $tidakTerjadwalRepo;
    }

    /**
     * Display a listing of the TidakTerjadwals.
     * GET|HEAD /tidak-terjadwals
     */
    public function index(Request $request): JsonResponse
    {
        $tidakTerjadwals = $this->tidakTerjadwalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($tidakTerjadwals->toArray(), 'Tidak Terjadwals retrieved successfully');
    }

    /**
     * Store a newly created TidakTerjadwal in storage.
     * POST /tidak-terjadwals
     */
    public function store(CreateTidakTerjadwalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $tidakTerjadwal = $this->tidakTerjadwalRepository->create($input);

        return $this->sendResponse($tidakTerjadwal->toArray(), 'Tidak Terjadwal saved successfully');
    }

    /**
     * Display the specified TidakTerjadwal.
     * GET|HEAD /tidak-terjadwals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var TidakTerjadwal $tidakTerjadwal */
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            return $this->sendError('Tidak Terjadwal not found');
        }

        return $this->sendResponse($tidakTerjadwal->toArray(), 'Tidak Terjadwal retrieved successfully');
    }

    /**
     * Update the specified TidakTerjadwal in storage.
     * PUT/PATCH /tidak-terjadwals/{id}
     */
    public function update($id, UpdateTidakTerjadwalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TidakTerjadwal $tidakTerjadwal */
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            return $this->sendError('Tidak Terjadwal not found');
        }

        $tidakTerjadwal = $this->tidakTerjadwalRepository->update($input, $id);

        return $this->sendResponse($tidakTerjadwal->toArray(), 'TidakTerjadwal updated successfully');
    }

    /**
     * Remove the specified TidakTerjadwal from storage.
     * DELETE /tidak-terjadwals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TidakTerjadwal $tidakTerjadwal */
        $tidakTerjadwal = $this->tidakTerjadwalRepository->find($id);

        if (empty($tidakTerjadwal)) {
            return $this->sendError('Tidak Terjadwal not found');
        }

        $tidakTerjadwal->delete();

        return $this->sendSuccess('Tidak Terjadwal deleted successfully');
    }
}
