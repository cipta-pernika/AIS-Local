<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaPemanduanKapalTrisaktiAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaPemanduanKapalTrisaktiAPIRequest;
use App\Models\PNBPJasaPemanduanKapalTrisakti;
use App\Repositories\PNBPJasaPemanduanKapalTrisaktiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaPemanduanKapalTrisaktiAPIController
 */
class PNBPJasaPemanduanKapalTrisaktiAPIController extends AppBaseController
{
    private PNBPJasaPemanduanKapalTrisaktiRepository $pNBPJasaPemanduanKapalTrisaktiRepository;

    public function __construct(PNBPJasaPemanduanKapalTrisaktiRepository $pNBPJasaPemanduanKapalTrisaktiRepo)
    {
        $this->pNBPJasaPemanduanKapalTrisaktiRepository = $pNBPJasaPemanduanKapalTrisaktiRepo;
    }

    /**
     * Display a listing of the PNBPJasaPemanduanKapalTrisaktis.
     * GET|HEAD /p-n-b-p-jasa-pemanduan-kapal-trisaktis
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaPemanduanKapalTrisaktis = $this->pNBPJasaPemanduanKapalTrisaktiRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaPemanduanKapalTrisaktis->toArray(), 'P N B P Jasa Pemanduan Kapal Trisaktis retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaPemanduanKapalTrisakti in storage.
     * POST /p-n-b-p-jasa-pemanduan-kapal-trisaktis
     */
    public function store(CreatePNBPJasaPemanduanKapalTrisaktiAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->create($input);

        return $this->sendResponse($pNBPJasaPemanduanKapalTrisakti->toArray(), 'P N B P Jasa Pemanduan Kapal Trisakti saved successfully');
    }

    /**
     * Display the specified PNBPJasaPemanduanKapalTrisakti.
     * GET|HEAD /p-n-b-p-jasa-pemanduan-kapal-trisaktis/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaPemanduanKapalTrisakti $pNBPJasaPemanduanKapalTrisakti */
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            return $this->sendError('P N B P Jasa Pemanduan Kapal Trisakti not found');
        }

        return $this->sendResponse($pNBPJasaPemanduanKapalTrisakti->toArray(), 'P N B P Jasa Pemanduan Kapal Trisakti retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaPemanduanKapalTrisakti in storage.
     * PUT/PATCH /p-n-b-p-jasa-pemanduan-kapal-trisaktis/{id}
     */
    public function update($id, UpdatePNBPJasaPemanduanKapalTrisaktiAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaPemanduanKapalTrisakti $pNBPJasaPemanduanKapalTrisakti */
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            return $this->sendError('P N B P Jasa Pemanduan Kapal Trisakti not found');
        }

        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaPemanduanKapalTrisakti->toArray(), 'PNBPJasaPemanduanKapalTrisakti updated successfully');
    }

    /**
     * Remove the specified PNBPJasaPemanduanKapalTrisakti from storage.
     * DELETE /p-n-b-p-jasa-pemanduan-kapal-trisaktis/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaPemanduanKapalTrisakti $pNBPJasaPemanduanKapalTrisakti */
        $pNBPJasaPemanduanKapalTrisakti = $this->pNBPJasaPemanduanKapalTrisaktiRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalTrisakti)) {
            return $this->sendError('P N B P Jasa Pemanduan Kapal Trisakti not found');
        }

        $pNBPJasaPemanduanKapalTrisakti->delete();

        return $this->sendSuccess('P N B P Jasa Pemanduan Kapal Trisakti deleted successfully');
    }
}
