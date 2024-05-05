<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaRambuKapalAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaRambuKapalAPIRequest;
use App\Models\PNBPJasaRambuKapal;
use App\Repositories\PNBPJasaRambuKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaRambuKapalAPIController
 */
class PNBPJasaRambuKapalAPIController extends AppBaseController
{
    private PNBPJasaRambuKapalRepository $pNBPJasaRambuKapalRepository;

    public function __construct(PNBPJasaRambuKapalRepository $pNBPJasaRambuKapalRepo)
    {
        $this->pNBPJasaRambuKapalRepository = $pNBPJasaRambuKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaRambuKapals.
     * GET|HEAD /p-n-b-p-jasa-rambu-kapals
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaRambuKapals = $this->pNBPJasaRambuKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaRambuKapals->toArray(), 'P N B P Jasa Rambu Kapals retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaRambuKapal in storage.
     * POST /p-n-b-p-jasa-rambu-kapals
     */
    public function store(CreatePNBPJasaRambuKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->create($input);

        return $this->sendResponse($pNBPJasaRambuKapal->toArray(), 'P N B P Jasa Rambu Kapal saved successfully');
    }

    /**
     * Display the specified PNBPJasaRambuKapal.
     * GET|HEAD /p-n-b-p-jasa-rambu-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaRambuKapal $pNBPJasaRambuKapal */
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            return $this->sendError('P N B P Jasa Rambu Kapal not found');
        }

        return $this->sendResponse($pNBPJasaRambuKapal->toArray(), 'P N B P Jasa Rambu Kapal retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaRambuKapal in storage.
     * PUT/PATCH /p-n-b-p-jasa-rambu-kapals/{id}
     */
    public function update($id, UpdatePNBPJasaRambuKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaRambuKapal $pNBPJasaRambuKapal */
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            return $this->sendError('P N B P Jasa Rambu Kapal not found');
        }

        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaRambuKapal->toArray(), 'PNBPJasaRambuKapal updated successfully');
    }

    /**
     * Remove the specified PNBPJasaRambuKapal from storage.
     * DELETE /p-n-b-p-jasa-rambu-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaRambuKapal $pNBPJasaRambuKapal */
        $pNBPJasaRambuKapal = $this->pNBPJasaRambuKapalRepository->find($id);

        if (empty($pNBPJasaRambuKapal)) {
            return $this->sendError('P N B P Jasa Rambu Kapal not found');
        }

        $pNBPJasaRambuKapal->delete();

        return $this->sendSuccess('P N B P Jasa Rambu Kapal deleted successfully');
    }
}
