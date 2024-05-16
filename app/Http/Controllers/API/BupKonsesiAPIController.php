<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBupKonsesiAPIRequest;
use App\Http\Requests\API\UpdateBupKonsesiAPIRequest;
use App\Models\BupKonsesi;
use App\Repositories\BupKonsesiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class BupKonsesiAPIController
 */
class BupKonsesiAPIController extends AppBaseController
{
    private BupKonsesiRepository $bupKonsesiRepository;

    public function __construct(BupKonsesiRepository $bupKonsesiRepo)
    {
        $this->bupKonsesiRepository = $bupKonsesiRepo;
    }

    /**
     * Display a listing of the BupKonsesis.
     * GET|HEAD /bup-konsesis
     */
    public function index(Request $request): JsonResponse
    {
        $bupKonsesis = $this->bupKonsesiRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($bupKonsesis->toArray(), 'Bup Konsesis retrieved successfully');
    }

    /**
     * Store a newly created BupKonsesi in storage.
     * POST /bup-konsesis
     */
    public function store(CreateBupKonsesiAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $bupKonsesi = $this->bupKonsesiRepository->create($input);

        return $this->sendResponse($bupKonsesi->toArray(), 'Bup Konsesi saved successfully');
    }

    /**
     * Display the specified BupKonsesi.
     * GET|HEAD /bup-konsesis/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var BupKonsesi $bupKonsesi */
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            return $this->sendError('Bup Konsesi not found');
        }

        return $this->sendResponse($bupKonsesi->toArray(), 'Bup Konsesi retrieved successfully');
    }

    /**
     * Update the specified BupKonsesi in storage.
     * PUT/PATCH /bup-konsesis/{id}
     */
    public function update($id, UpdateBupKonsesiAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var BupKonsesi $bupKonsesi */
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            return $this->sendError('Bup Konsesi not found');
        }

        $bupKonsesi = $this->bupKonsesiRepository->update($input, $id);

        return $this->sendResponse($bupKonsesi->toArray(), 'BupKonsesi updated successfully');
    }

    /**
     * Remove the specified BupKonsesi from storage.
     * DELETE /bup-konsesis/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var BupKonsesi $bupKonsesi */
        $bupKonsesi = $this->bupKonsesiRepository->find($id);

        if (empty($bupKonsesi)) {
            return $this->sendError('Bup Konsesi not found');
        }

        $bupKonsesi->delete();

        return $this->sendSuccess('Bup Konsesi deleted successfully');
    }
}
