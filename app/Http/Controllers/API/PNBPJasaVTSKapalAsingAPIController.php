<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePNBPJasaVTSKapalAsingAPIRequest;
use App\Http\Requests\API\UpdatePNBPJasaVTSKapalAsingAPIRequest;
use App\Models\PNBPJasaVTSKapalAsing;
use App\Repositories\PNBPJasaVTSKapalAsingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PNBPJasaVTSKapalAsingAPIController
 */
class PNBPJasaVTSKapalAsingAPIController extends AppBaseController
{
    private PNBPJasaVTSKapalAsingRepository $pNBPJasaVTSKapalAsingRepository;

    public function __construct(PNBPJasaVTSKapalAsingRepository $pNBPJasaVTSKapalAsingRepo)
    {
        $this->pNBPJasaVTSKapalAsingRepository = $pNBPJasaVTSKapalAsingRepo;
    }

    /**
     * Display a listing of the PNBPJasaVTSKapalAsings.
     * GET|HEAD /p-n-b-p-jasa-v-t-s-kapal-asings
     */
    public function index(Request $request): JsonResponse
    {
        $pNBPJasaVTSKapalAsings = $this->pNBPJasaVTSKapalAsingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pNBPJasaVTSKapalAsings->toArray(), 'P N B P Jasa V T S Kapal Asings retrieved successfully');
    }

    /**
     * Store a newly created PNBPJasaVTSKapalAsing in storage.
     * POST /p-n-b-p-jasa-v-t-s-kapal-asings
     */
    public function store(CreatePNBPJasaVTSKapalAsingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->create($input);

        return $this->sendResponse($pNBPJasaVTSKapalAsing->toArray(), 'P N B P Jasa V T S Kapal Asing saved successfully');
    }

    /**
     * Display the specified PNBPJasaVTSKapalAsing.
     * GET|HEAD /p-n-b-p-jasa-v-t-s-kapal-asings/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PNBPJasaVTSKapalAsing $pNBPJasaVTSKapalAsing */
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            return $this->sendError('P N B P Jasa V T S Kapal Asing not found');
        }

        return $this->sendResponse($pNBPJasaVTSKapalAsing->toArray(), 'P N B P Jasa V T S Kapal Asing retrieved successfully');
    }

    /**
     * Update the specified PNBPJasaVTSKapalAsing in storage.
     * PUT/PATCH /p-n-b-p-jasa-v-t-s-kapal-asings/{id}
     */
    public function update($id, UpdatePNBPJasaVTSKapalAsingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PNBPJasaVTSKapalAsing $pNBPJasaVTSKapalAsing */
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            return $this->sendError('P N B P Jasa V T S Kapal Asing not found');
        }

        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->update($input, $id);

        return $this->sendResponse($pNBPJasaVTSKapalAsing->toArray(), 'PNBPJasaVTSKapalAsing updated successfully');
    }

    /**
     * Remove the specified PNBPJasaVTSKapalAsing from storage.
     * DELETE /p-n-b-p-jasa-v-t-s-kapal-asings/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PNBPJasaVTSKapalAsing $pNBPJasaVTSKapalAsing */
        $pNBPJasaVTSKapalAsing = $this->pNBPJasaVTSKapalAsingRepository->find($id);

        if (empty($pNBPJasaVTSKapalAsing)) {
            return $this->sendError('P N B P Jasa V T S Kapal Asing not found');
        }

        $pNBPJasaVTSKapalAsing->delete();

        return $this->sendSuccess('P N B P Jasa V T S Kapal Asing deleted successfully');
    }
}
