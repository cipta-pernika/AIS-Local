<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaLabuhKapalAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaLabuhKapalAPIRequest;
use App\Models\PNBPJasaLabuhKapal;
use App\Repositories\PNBPJasaLabuhKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaLabuhKapalAPIController
 */
class PNBPJasaLabuhKapalAPIController extends AppBaseController
{
    private PNBPJasaLabuhKapalRepository $pNBPJasaLabuhKapalRepository;

    public function __construct(PNBPJasaLabuhKapalRepository $pNBPJasaLabuhKapalRepo)
    {
        $this->pNBPJasaLabuhKapalRepository = $pNBPJasaLabuhKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaLabuhKapals.
     * GET|HEAD /p-n-b-p-jasa-labuh-kapals
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaLabuhKapals = $this->pNBPJasaLabuhKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaLabuhKapals->toArray(), 'P N B P Jasa Labuh Kapals retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaLabuhKapal in storage.
     * POST /p-n-b-p-jasa-labuh-kapals
     */
    public function store(CreatePNBPJasaLabuhKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->create($input);

        return $this->sendResponse($pNBPJasaLabuhKapal->toArray(), 'P N B P Jasa Labuh Kapal saved successfully');
    }

    /**
     * Display the specified PNBPJasaLabuhKapal.
     * GET|HEAD /p-n-b-p-jasa-labuh-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaLabuhKapal $pNBPJasaLabuhKapal */
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            return $this->sendError('P N B P Jasa Labuh Kapal not found');
        }

        return $this->sendResponse($pNBPJasaLabuhKapal->toArray(), 'P N B P Jasa Labuh Kapal retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaLabuhKapal in storage.
     * PUT/PATCH /p-n-b-p-jasa-labuh-kapals/{id}
     */
    public function update($id, UpdatePNBPJasaLabuhKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaLabuhKapal $pNBPJasaLabuhKapal */
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            return $this->sendError('P N B P Jasa Labuh Kapal not found');
        }

        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaLabuhKapal->toArray(), 'PNBPJasaLabuhKapal updated successfully');
    }

    /**
     * Remove the specified PNBPJasaLabuhKapal from storage.
     * DELETE /p-n-b-p-jasa-labuh-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaLabuhKapal $pNBPJasaLabuhKapal */
        $pNBPJasaLabuhKapal = $this->pNBPJasaLabuhKapalRepository->find($id);

        if (empty($pNBPJasaLabuhKapal)) {
            return $this->sendError('P N B P Jasa Labuh Kapal not found');
        }

        $pNBPJasaLabuhKapal->delete();

        return $this->sendSuccess('P N B P Jasa Labuh Kapal deleted successfully');
    }
}
