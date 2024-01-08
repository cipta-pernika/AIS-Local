<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInaportnetPergerakanKapalAPIRequest;
use App\Http\Requests\API\UpdateInaportnetPergerakanKapalAPIRequest;
use App\Models\InaportnetPergerakanKapal;
use App\Repositories\InaportnetPergerakanKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class InaportnetPergerakanKapalAPIController
 */
class InaportnetPergerakanKapalAPIController extends AppBaseController
{
    private InaportnetPergerakanKapalRepository $inaportnetPergerakanKapalRepository;

    public function __construct(InaportnetPergerakanKapalRepository $inaportnetPergerakanKapalRepo)
    {
        $this->inaportnetPergerakanKapalRepository = $inaportnetPergerakanKapalRepo;
    }

    /**
     * Display a listing of the InaportnetPergerakanKapals.
     * GET|HEAD /inaportnet-pergerakan-kapals
     */
    public function index(Request $request): JsonResponse
    {
        $inaportnetPergerakanKapals = $this->inaportnetPergerakanKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($inaportnetPergerakanKapals->toArray(), 'Inaportnet Pergerakan Kapals retrieved successfully');
    }

    /**
     * Store a newly created InaportnetPergerakanKapal in storage.
     * POST /inaportnet-pergerakan-kapals
     */
    public function store(CreateInaportnetPergerakanKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->create($input);

        return $this->sendResponse($inaportnetPergerakanKapal->toArray(), 'Inaportnet Pergerakan Kapal saved successfully');
    }

    /**
     * Display the specified InaportnetPergerakanKapal.
     * GET|HEAD /inaportnet-pergerakan-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var InaportnetPergerakanKapal $inaportnetPergerakanKapal */
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            return $this->sendError('Inaportnet Pergerakan Kapal not found');
        }

        return $this->sendResponse($inaportnetPergerakanKapal->toArray(), 'Inaportnet Pergerakan Kapal retrieved successfully');
    }

    /**
     * Update the specified InaportnetPergerakanKapal in storage.
     * PUT/PATCH /inaportnet-pergerakan-kapals/{id}
     */
    public function update($id, UpdateInaportnetPergerakanKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var InaportnetPergerakanKapal $inaportnetPergerakanKapal */
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            return $this->sendError('Inaportnet Pergerakan Kapal not found');
        }

        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->update($input, $id);

        return $this->sendResponse($inaportnetPergerakanKapal->toArray(), 'InaportnetPergerakanKapal updated successfully');
    }

    /**
     * Remove the specified InaportnetPergerakanKapal from storage.
     * DELETE /inaportnet-pergerakan-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var InaportnetPergerakanKapal $inaportnetPergerakanKapal */
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            return $this->sendError('Inaportnet Pergerakan Kapal not found');
        }

        $inaportnetPergerakanKapal->delete();

        return $this->sendSuccess('Inaportnet Pergerakan Kapal deleted successfully');
    }
}
