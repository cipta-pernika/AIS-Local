<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaTambatKapalAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaTambatKapalAPIRequest;
use App\Models\PNBPJasaTambatKapal;
use App\Repositories\PNBPJasaTambatKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaTambatKapalAPIController
 */
class PNBPJasaTambatKapalAPIController extends AppBaseController
{
    private PNBPJasaTambatKapalRepository $pNBPJasaTambatKapalRepository;

    public function __construct(PNBPJasaTambatKapalRepository $pNBPJasaTambatKapalRepo)
    {
        $this->pNBPJasaTambatKapalRepository = $pNBPJasaTambatKapalRepo;
    }

    /**
     * Display a listing of the PNBPJasaTambatKapals.
     * GET|HEAD /p-n-b-p-jasa-tambat-kapals
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaTambatKapals = $this->pNBPJasaTambatKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaTambatKapals->toArray(), 'P N B P Jasa Tambat Kapals retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaTambatKapal in storage.
     * POST /p-n-b-p-jasa-tambat-kapals
     */
    public function store(CreatePNBPJasaTambatKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->create($input);

        return $this->sendResponse($pNBPJasaTambatKapal->toArray(), 'P N B P Jasa Tambat Kapal saved successfully');
    }

    /**
     * Display the specified PNBPJasaTambatKapal.
     * GET|HEAD /p-n-b-p-jasa-tambat-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaTambatKapal $pNBPJasaTambatKapal */
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            return $this->sendError('P N B P Jasa Tambat Kapal not found');
        }

        return $this->sendResponse($pNBPJasaTambatKapal->toArray(), 'P N B P Jasa Tambat Kapal retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaTambatKapal in storage.
     * PUT/PATCH /p-n-b-p-jasa-tambat-kapals/{id}
     */
    public function update($id, UpdatePNBPJasaTambatKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaTambatKapal $pNBPJasaTambatKapal */
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            return $this->sendError('P N B P Jasa Tambat Kapal not found');
        }

        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaTambatKapal->toArray(), 'PNBPJasaTambatKapal updated successfully');
    }

    /**
     * Remove the specified PNBPJasaTambatKapal from storage.
     * DELETE /p-n-b-p-jasa-tambat-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaTambatKapal $pNBPJasaTambatKapal */
        $pNBPJasaTambatKapal = $this->pNBPJasaTambatKapalRepository->find($id);

        if (empty($pNBPJasaTambatKapal)) {
            return $this->sendError('P N B P Jasa Tambat Kapal not found');
        }

        $pNBPJasaTambatKapal->delete();

        return $this->sendSuccess('P N B P Jasa Tambat Kapal deleted successfully');
    }
}
