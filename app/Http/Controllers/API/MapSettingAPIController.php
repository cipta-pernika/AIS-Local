<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMapSettingAPIRequest;
use App\Http\Requests\API\UpdateMapSettingAPIRequest;
use App\Models\MapSetting;
use App\Repositories\MapSettingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class MapSettingAPIController
 */
class MapSettingAPIController extends AppBaseController
{
    private MapSettingRepository $mapSettingRepository;

    public function __construct(MapSettingRepository $mapSettingRepo)
    {
        $this->mapSettingRepository = $mapSettingRepo;
    }

    /**
     * Display a listing of the MapSettings.
     * GET|HEAD /map-settings
     */
    public function index(Request $request): JsonResponse
    {
        $mapSettings = $this->mapSettingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($mapSettings->toArray(), 'Map Settings retrieved successfully');
    }

    /**
     * Store a newly created MapSetting in storage.
     * POST /map-settings
     */
    public function store(CreateMapSettingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $mapSetting = $this->mapSettingRepository->create($input);

        return $this->sendResponse($mapSetting->toArray(), 'Map Setting saved successfully');
    }

    /**
     * Display the specified MapSetting.
     * GET|HEAD /map-settings/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var MapSetting $mapSetting */
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            return $this->sendError('Map Setting not found');
        }

        return $this->sendResponse($mapSetting->toArray(), 'Map Setting retrieved successfully');
    }

    /**
     * Update the specified MapSetting in storage.
     * PUT/PATCH /map-settings/{id}
     */
    public function update($id, UpdateMapSettingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var MapSetting $mapSetting */
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            return $this->sendError('Map Setting not found');
        }

        $mapSetting = $this->mapSettingRepository->update($input, $id);

        return $this->sendResponse($mapSetting->toArray(), 'MapSetting updated successfully');
    }

    /**
     * Remove the specified MapSetting from storage.
     * DELETE /map-settings/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var MapSetting $mapSetting */
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            return $this->sendError('Map Setting not found');
        }

        $mapSetting->delete();

        return $this->sendSuccess('Map Setting deleted successfully');
    }
}
