<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTerminalAPIRequest;
use App\Http\Requests\API\UpdateTerminalAPIRequest;
use App\Models\Terminal;
use App\Repositories\TerminalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TerminalAPIController
 */
class TerminalAPIController extends AppBaseController
{
    private TerminalRepository $terminalRepository;

    public function __construct(TerminalRepository $terminalRepo)
    {
        $this->terminalRepository = $terminalRepo;
    }

    /**
     * Display a listing of the Terminals.
     * GET|HEAD /terminals
     */
    public function index(Request $request): JsonResponse
    {
        $terminals = $this->terminalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($terminals->toArray(), 'Terminals retrieved successfully');
    }

    /**
     * Store a newly created Terminal in storage.
     * POST /terminals
     */
    public function store(CreateTerminalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $terminal = $this->terminalRepository->create($input);

        return $this->sendResponse($terminal->toArray(), 'Terminal saved successfully');
    }

    /**
     * Display the specified Terminal.
     * GET|HEAD /terminals/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Terminal $terminal */
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            return $this->sendError('Terminal not found');
        }

        return $this->sendResponse($terminal->toArray(), 'Terminal retrieved successfully');
    }

    /**
     * Update the specified Terminal in storage.
     * PUT/PATCH /terminals/{id}
     */
    public function update($id, UpdateTerminalAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Terminal $terminal */
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            return $this->sendError('Terminal not found');
        }

        $terminal = $this->terminalRepository->update($input, $id);

        return $this->sendResponse($terminal->toArray(), 'Terminal updated successfully');
    }

    /**
     * Remove the specified Terminal from storage.
     * DELETE /terminals/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Terminal $terminal */
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            return $this->sendError('Terminal not found');
        }

        $terminal->delete();

        return $this->sendSuccess('Terminal deleted successfully');
    }
}
