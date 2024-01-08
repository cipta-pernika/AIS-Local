<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateImptPelayananKapalAPIRequest;
use App\Http\Requests\API\UpdateImptPelayananKapalAPIRequest;
use App\Models\ImptPelayananKapal;
use App\Repositories\ImptPelayananKapalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ImptPelayananKapalAPIController
 */
class ImptPelayananKapalAPIController extends AppBaseController
{
    private ImptPelayananKapalRepository $imptPelayananKapalRepository;

    public function __construct(ImptPelayananKapalRepository $imptPelayananKapalRepo)
    {
        $this->imptPelayananKapalRepository = $imptPelayananKapalRepo;
    }

    /**
     * Display a listing of the ImptPelayananKapals.
     * GET|HEAD /impt-pelayanan-kapals
     */
    public function index(Request $request): JsonResponse
    {
        $imptPelayananKapals = $this->imptPelayananKapalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($imptPelayananKapals->toArray(), 'Impt Pelayanan Kapals retrieved successfully');
    }

    /**
     * Store a newly created ImptPelayananKapal in storage.
     * POST /impt-pelayanan-kapals
     */
    public function store(CreateImptPelayananKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $imptPelayananKapal = $this->imptPelayananKapalRepository->create($input);

        return $this->sendResponse($imptPelayananKapal->toArray(), 'Impt Pelayanan Kapal saved successfully');
    }

    /**
     * Display the specified ImptPelayananKapal.
     * GET|HEAD /impt-pelayanan-kapals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ImptPelayananKapal $imptPelayananKapal */
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            return $this->sendError('Impt Pelayanan Kapal not found');
        }

        return $this->sendResponse($imptPelayananKapal->toArray(), 'Impt Pelayanan Kapal retrieved successfully');
    }

    /**
     * Update the specified ImptPelayananKapal in storage.
     * PUT/PATCH /impt-pelayanan-kapals/{id}
     */
    public function update($id, UpdateImptPelayananKapalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ImptPelayananKapal $imptPelayananKapal */
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            return $this->sendError('Impt Pelayanan Kapal not found');
        }

        $imptPelayananKapal = $this->imptPelayananKapalRepository->update($input, $id);

        return $this->sendResponse($imptPelayananKapal->toArray(), 'ImptPelayananKapal updated successfully');
    }

    /**
     * Remove the specified ImptPelayananKapal from storage.
     * DELETE /impt-pelayanan-kapals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ImptPelayananKapal $imptPelayananKapal */
        $imptPelayananKapal = $this->imptPelayananKapalRepository->find($id);

        if (empty($imptPelayananKapal)) {
            return $this->sendError('Impt Pelayanan Kapal not found');
        }

        $imptPelayananKapal->delete();

        return $this->sendSuccess('Impt Pelayanan Kapal deleted successfully');
    }
}
