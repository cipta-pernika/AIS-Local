<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDataBUPAPIRequest;
use App\Http\Requests\API\UpdateDataBUPAPIRequest;
use App\Models\DataBUP;
use App\Repositories\DataBUPRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DataBUPAPIController
 */
class DataBUPAPIController extends AppBaseController
{
    private DataBUPRepository $dataBUPRepository;

    public function __construct(DataBUPRepository $dataBUPRepo)
    {
        $this->dataBUPRepository = $dataBUPRepo;
    }

    /**
     * Display a listing of the DataBUPs.
     * GET|HEAD /data-b-u-ps
     */
    public function index(Request $request): JsonResponse
    {
        $dataBUPs = $this->dataBUPRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($dataBUPs->toArray(), 'Data B U Ps retrieved successfully');
    }

    /**
     * Store a newly created DataBUP in storage.
     * POST /data-b-u-ps
     */
    public function store(CreateDataBUPAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $dataBUP = $this->dataBUPRepository->create($input);

        return $this->sendResponse($dataBUP->toArray(), 'Data B U P saved successfully');
    }

    /**
     * Display the specified DataBUP.
     * GET|HEAD /data-b-u-ps/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var DataBUP $dataBUP */
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            return $this->sendError('Data B U P not found');
        }

        return $this->sendResponse($dataBUP->toArray(), 'Data B U P retrieved successfully');
    }

    /**
     * Update the specified DataBUP in storage.
     * PUT/PATCH /data-b-u-ps/{id}
     */
    public function update($id, UpdateDataBUPAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DataBUP $dataBUP */
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            return $this->sendError('Data B U P not found');
        }

        $dataBUP = $this->dataBUPRepository->update($input, $id);

        return $this->sendResponse($dataBUP->toArray(), 'DataBUP updated successfully');
    }

    /**
     * Remove the specified DataBUP from storage.
     * DELETE /data-b-u-ps/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var DataBUP $dataBUP */
        $dataBUP = $this->dataBUPRepository->find($id);

        if (empty($dataBUP)) {
            return $this->sendError('Data B U P not found');
        }

        $dataBUP->delete();

        return $this->sendSuccess('Data B U P deleted successfully');
    }
}
