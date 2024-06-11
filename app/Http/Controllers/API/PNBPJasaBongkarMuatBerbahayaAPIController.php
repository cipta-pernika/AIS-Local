<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaBongkarMuatBerbahayaAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaBongkarMuatBerbahayaAPIRequest;
use App\Models\PNBPJasaBongkarMuatBerbahaya;
use App\Repositories\PNBPJasaBongkarMuatBerbahayaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaBongkarMuatBerbahayaAPIController
 */
class PNBPJasaBongkarMuatBerbahayaAPIController extends AppBaseController
{
    private PNBPJasaBongkarMuatBerbahayaRepository $pNBPJasaBongkarMuatBerbahayaRepository;

    public function __construct(PNBPJasaBongkarMuatBerbahayaRepository $pNBPJasaBongkarMuatBerbahayaRepo)
    {
        $this->pNBPJasaBongkarMuatBerbahayaRepository = $pNBPJasaBongkarMuatBerbahayaRepo;
    }

    /**
     * Display a listing of the PNBPJasaBongkarMuatBerbahayas.
     * GET|HEAD /p-n-b-p-jasa-bongkar-muat-berbahayas
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaBongkarMuatBerbahayas = $this->pNBPJasaBongkarMuatBerbahayaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaBongkarMuatBerbahayas->toArray(), 'P N B P Jasa Bongkar Muat Berbahayas retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaBongkarMuatBerbahaya in storage.
     * POST /p-n-b-p-jasa-bongkar-muat-berbahayas
     */
    public function store(CreatePNBPJasaBongkarMuatBerbahayaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->create($input);

        return $this->sendResponse($pNBPJasaBongkarMuatBerbahaya->toArray(), 'P N B P Jasa Bongkar Muat Berbahaya saved successfully');
    }

    /**
     * Display the specified PNBPJasaBongkarMuatBerbahaya.
     * GET|HEAD /p-n-b-p-jasa-bongkar-muat-berbahayas/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaBongkarMuatBerbahaya $pNBPJasaBongkarMuatBerbahaya */
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            return $this->sendError('P N B P Jasa Bongkar Muat Berbahaya not found');
        }

        return $this->sendResponse($pNBPJasaBongkarMuatBerbahaya->toArray(), 'P N B P Jasa Bongkar Muat Berbahaya retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaBongkarMuatBerbahaya in storage.
     * PUT/PATCH /p-n-b-p-jasa-bongkar-muat-berbahayas/{id}
     */
    public function update($id, UpdatePNBPJasaBongkarMuatBerbahayaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaBongkarMuatBerbahaya $pNBPJasaBongkarMuatBerbahaya */
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            return $this->sendError('P N B P Jasa Bongkar Muat Berbahaya not found');
        }

        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaBongkarMuatBerbahaya->toArray(), 'PNBPJasaBongkarMuatBerbahaya updated successfully');
    }

    /**
     * Remove the specified PNBPJasaBongkarMuatBerbahaya from storage.
     * DELETE /p-n-b-p-jasa-bongkar-muat-berbahayas/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaBongkarMuatBerbahaya $pNBPJasaBongkarMuatBerbahaya */
        $pNBPJasaBongkarMuatBerbahaya = $this->pNBPJasaBongkarMuatBerbahayaRepository->find($id);

        if (empty($pNBPJasaBongkarMuatBerbahaya)) {
            return $this->sendError('P N B P Jasa Bongkar Muat Berbahaya not found');
        }

        $pNBPJasaBongkarMuatBerbahaya->delete();

        return $this->sendSuccess('P N B P Jasa Bongkar Muat Berbahaya deleted successfully');
    }
}
