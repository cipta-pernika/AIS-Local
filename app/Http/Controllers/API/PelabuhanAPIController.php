<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePelabuhanAPIRequest;
use App\Http\Requests\API\UpdatePelabuhanAPIRequest;
use App\Models\Pelabuhan;
use App\Repositories\PelabuhanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PelabuhanAPIController
 */
class PelabuhanAPIController extends AppBaseController
{
    private PelabuhanRepository $pelabuhanRepository;

    public function __construct(PelabuhanRepository $pelabuhanRepo)
    {
        $this->pelabuhanRepository = $pelabuhanRepo;
    }

    /**
     * Display a listing of the Pelabuhans.
     * GET|HEAD /pelabuhans
     */
    public function index(Request $request): JsonResponse
    {
        $pelabuhans = $this->pelabuhanRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pelabuhans->toArray(), 'Pelabuhans retrieved successfully');
    }

    /**
     * Store a newly created Pelabuhan in storage.
     * POST /pelabuhans
     */
    public function store(CreatePelabuhanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pelabuhan = $this->pelabuhanRepository->create($input);

        return $this->sendResponse($pelabuhan->toArray(), 'Pelabuhan saved successfully');
    }

    /**
     * Display the specified Pelabuhan.
     * GET|HEAD /pelabuhans/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Pelabuhan $pelabuhan */
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            return $this->sendError('Pelabuhan not found');
        }

        return $this->sendResponse($pelabuhan->toArray(), 'Pelabuhan retrieved successfully');
    }

    /**
     * Update the specified Pelabuhan in storage.
     * PUT/PATCH /pelabuhans/{id}
     */
    public function update($id, UpdatePelabuhanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Pelabuhan $pelabuhan */
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            return $this->sendError('Pelabuhan not found');
        }

        $pelabuhan = $this->pelabuhanRepository->update($input, $id);

        return $this->sendResponse($pelabuhan->toArray(), 'Pelabuhan updated successfully');
    }

    /**
     * Remove the specified Pelabuhan from storage.
     * DELETE /pelabuhans/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Pelabuhan $pelabuhan */
        $pelabuhan = $this->pelabuhanRepository->find($id);

        if (empty($pelabuhan)) {
            return $this->sendError('Pelabuhan not found');
        }

        $pelabuhan->delete();

        return $this->sendSuccess('Pelabuhan deleted successfully');
    }
}
