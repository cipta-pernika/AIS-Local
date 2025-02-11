<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKonsolidasiAPIRequest;
use App\Http\Requests\API\UpdateKonsolidasiAPIRequest;
use App\Models\Konsolidasi;
use App\Repositories\KonsolidasiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class KonsolidasiAPIController
 */
class KonsolidasiAPIController extends AppBaseController
{
    private KonsolidasiRepository $konsolidasiRepository;

    public function __construct(KonsolidasiRepository $konsolidasiRepo)
    {
        $this->konsolidasiRepository = $konsolidasiRepo;
    }

    /**
     * Display a listing of the Konsolidasis.
     * GET|HEAD /konsolidasis
     */
    public function index(Request $request): JsonResponse
    {
        $konsolidasis = $this->konsolidasiRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($konsolidasis->toArray(), 'Konsolidasis retrieved successfully');
    }

    /**
     * Store a newly created Konsolidasi in storage.
     * POST /konsolidasis
     */
    public function store(CreateKonsolidasiAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $konsolidasi = $this->konsolidasiRepository->create($input);

        return $this->sendResponse($konsolidasi->toArray(), 'Konsolidasi saved successfully');
    }

    /**
     * Display the specified Konsolidasi.
     * GET|HEAD /konsolidasis/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Konsolidasi $konsolidasi */
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            return $this->sendError('Konsolidasi not found');
        }

        return $this->sendResponse($konsolidasi->toArray(), 'Konsolidasi retrieved successfully');
    }

    /**
     * Update the specified Konsolidasi in storage.
     * PUT/PATCH /konsolidasis/{id}
     */
    public function update($id, UpdateKonsolidasiAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Konsolidasi $konsolidasi */
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            return $this->sendError('Konsolidasi not found');
        }

        $konsolidasi = $this->konsolidasiRepository->update($input, $id);

        return $this->sendResponse($konsolidasi->toArray(), 'Konsolidasi updated successfully');
    }

    /**
     * Remove the specified Konsolidasi from storage.
     * DELETE /konsolidasis/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Konsolidasi $konsolidasi */
        $konsolidasi = $this->konsolidasiRepository->find($id);

        if (empty($konsolidasi)) {
            return $this->sendError('Konsolidasi not found');
        }

        $konsolidasi->delete();

        return $this->sendSuccess('Konsolidasi deleted successfully');
    }
}
