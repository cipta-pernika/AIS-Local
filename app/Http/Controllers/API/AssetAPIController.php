<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAssetAPIRequest;
use App\Http\Requests\API\UpdateAssetAPIRequest;
use App\Models\Asset;
use App\Repositories\AssetRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AssetAPIController
 */
class AssetAPIController extends AppBaseController
{
    private AssetRepository $assetRepository;

    public function __construct(AssetRepository $assetRepo)
    {
        $this->assetRepository = $assetRepo;
    }

    /**
     * Display a listing of the Assets.
     * GET|HEAD /assets
     */
    public function index(Request $request): JsonResponse
    {
        $assets = $this->assetRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($assets->toArray(), 'Assets retrieved successfully');
    }

    /**
     * Store a newly created Asset in storage.
     * POST /assets
     */
    public function store(CreateAssetAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $asset = $this->assetRepository->create($input);

        return $this->sendResponse($asset->toArray(), 'Asset saved successfully');
    }

    /**
     * Display the specified Asset.
     * GET|HEAD /assets/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Asset $asset */
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            return $this->sendError('Asset not found');
        }

        return $this->sendResponse($asset->toArray(), 'Asset retrieved successfully');
    }

    /**
     * Update the specified Asset in storage.
     * PUT/PATCH /assets/{id}
     */
    public function update($id, UpdateAssetAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Asset $asset */
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            return $this->sendError('Asset not found');
        }

        $asset = $this->assetRepository->update($input, $id);

        return $this->sendResponse($asset->toArray(), 'Asset updated successfully');
    }

    /**
     * Remove the specified Asset from storage.
     * DELETE /assets/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Asset $asset */
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            return $this->sendError('Asset not found');
        }

        $asset->delete();

        return $this->sendSuccess('Asset deleted successfully');
    }
}
