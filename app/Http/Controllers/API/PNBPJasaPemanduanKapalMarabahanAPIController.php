<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaPemanduanKapalMarabahanAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaPemanduanKapalMarabahanAPIRequest;
use App\Models\PNBPJasaPemanduanKapalMarabahan;
use App\Repositories\PNBPJasaPemanduanKapalMarabahanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaPemanduanKapalMarabahanAPIController
 */
class PNBPJasaPemanduanKapalMarabahanAPIController extends AppBaseController
{
    private PNBPJasaPemanduanKapalMarabahanRepository $pNBPJasaPemanduanKapalMarabahanRepository;

    public function __construct(PNBPJasaPemanduanKapalMarabahanRepository $pNBPJasaPemanduanKapalMarabahanRepo)
    {
        $this->pNBPJasaPemanduanKapalMarabahanRepository = $pNBPJasaPemanduanKapalMarabahanRepo;
    }

    /**
     * Display a listing of the PNBPJasaPemanduanKapalMarabahans.
     * GET|HEAD /p-n-b-p-jasa-pemanduan-kapal-marabahans
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaPemanduanKapalMarabahans = $this->pNBPJasaPemanduanKapalMarabahanRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaPemanduanKapalMarabahans->toArray(), 'P N B P Jasa Pemanduan Kapal Marabahans retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaPemanduanKapalMarabahan in storage.
     * POST /p-n-b-p-jasa-pemanduan-kapal-marabahans
     */
    public function store(CreatePNBPJasaPemanduanKapalMarabahanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->create($input);

        return $this->sendResponse($pNBPJasaPemanduanKapalMarabahan->toArray(), 'P N B P Jasa Pemanduan Kapal Marabahan saved successfully');
    }

    /**
     * Display the specified PNBPJasaPemanduanKapalMarabahan.
     * GET|HEAD /p-n-b-p-jasa-pemanduan-kapal-marabahans/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaPemanduanKapalMarabahan $pNBPJasaPemanduanKapalMarabahan */
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            return $this->sendError('P N B P Jasa Pemanduan Kapal Marabahan not found');
        }

        return $this->sendResponse($pNBPJasaPemanduanKapalMarabahan->toArray(), 'P N B P Jasa Pemanduan Kapal Marabahan retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaPemanduanKapalMarabahan in storage.
     * PUT/PATCH /p-n-b-p-jasa-pemanduan-kapal-marabahans/{id}
     */
    public function update($id, UpdatePNBPJasaPemanduanKapalMarabahanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaPemanduanKapalMarabahan $pNBPJasaPemanduanKapalMarabahan */
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            return $this->sendError('P N B P Jasa Pemanduan Kapal Marabahan not found');
        }

        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaPemanduanKapalMarabahan->toArray(), 'PNBPJasaPemanduanKapalMarabahan updated successfully');
    }

    /**
     * Remove the specified PNBPJasaPemanduanKapalMarabahan from storage.
     * DELETE /p-n-b-p-jasa-pemanduan-kapal-marabahans/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaPemanduanKapalMarabahan $pNBPJasaPemanduanKapalMarabahan */
        $pNBPJasaPemanduanKapalMarabahan = $this->pNBPJasaPemanduanKapalMarabahanRepository->find($id);

        if (empty($pNBPJasaPemanduanKapalMarabahan)) {
            return $this->sendError('P N B P Jasa Pemanduan Kapal Marabahan not found');
        }

        $pNBPJasaPemanduanKapalMarabahan->delete();

        return $this->sendSuccess('P N B P Jasa Pemanduan Kapal Marabahan deleted successfully');
    }
}
