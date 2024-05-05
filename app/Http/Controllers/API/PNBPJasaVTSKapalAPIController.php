<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaVTSKapalAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaVTSKapalAPIRequest;
use App\Models\PNBPJasaVTSKapal;
use App\Repositories\PNBPJasaVTSKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaVTSKapalAPIController
 */
class PNBPJasaVTSKapalAPIController extends AppBaseController
{
    private PNBPJasaVTSKapalRepository $pNBPJasaVTSKapalRepository;

    public function __construct(PNBPJasaVTSKapalRepository $pNBPJasaVTSKapalRepo)
    {
        $this->pNBPJasaVTSKapalRepository = $pNBPJasaVTSKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaVTSKapals.
     * GET|HEAD /p-n-b-p-jasa-v-t-s-kapals
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaVTSKapals = $this->pNBPJasaVTSKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaVTSKapals->toArray(), 'P N B P Jasa V T S Kapals retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaVTSKapal in storage.
     * POST /p-n-b-p-jasa-v-t-s-kapals
     */
    public function store(CreatePNBPJasaVTSKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->create($input);

        return $this->sendResponse($pNBPJasaVTSKapal->toArray(), 'P N B P Jasa V T S Kapal saved successfully');
    }

    /**
     * Display the specified PNBPJasaVTSKapal.
     * GET|HEAD /p-n-b-p-jasa-v-t-s-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaVTSKapal $pNBPJasaVTSKapal */
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            return $this->sendError('P N B P Jasa V T S Kapal not found');
        }

        return $this->sendResponse($pNBPJasaVTSKapal->toArray(), 'P N B P Jasa V T S Kapal retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaVTSKapal in storage.
     * PUT/PATCH /p-n-b-p-jasa-v-t-s-kapals/{id}
     */
    public function update($id, UpdatePNBPJasaVTSKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaVTSKapal $pNBPJasaVTSKapal */
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            return $this->sendError('P N B P Jasa V T S Kapal not found');
        }

        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaVTSKapal->toArray(), 'PNBPJasaVTSKapal updated successfully');
    }

    /**
     * Remove the specified PNBPJasaVTSKapal from storage.
     * DELETE /p-n-b-p-jasa-v-t-s-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaVTSKapal $pNBPJasaVTSKapal */
        $pNBPJasaVTSKapal = $this->pNBPJasaVTSKapalRepository->find($id);

        if (empty($pNBPJasaVTSKapal)) {
            return $this->sendError('P N B P Jasa V T S Kapal not found');
        }

        $pNBPJasaVTSKapal->delete();

        return $this->sendSuccess('P N B P Jasa V T S Kapal deleted successfully');
    }
}
