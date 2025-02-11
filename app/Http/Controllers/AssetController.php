<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AssetRepository;
use Illuminate\Http\Request;
use Flash;

class AssetController extends AppBaseController
{
    /** @var AssetRepository $assetRepository*/
    private $assetRepository;

    public function __construct(AssetRepository $assetRepo)
    {
        $this->assetRepository = $assetRepo;
    }

    /**
     * Display a listing of the Asset.
     */
    public function index(Request $request)
    {
        $assets = $this->assetRepository->paginate(10);

        return view('assets.index')
            ->with('assets', $assets);
    }

    /**
     * Show the form for creating a new Asset.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created Asset in storage.
     */
    public function store(CreateAssetRequest $request)
    {
        $input = $request->all();

        $asset = $this->assetRepository->create($input);

        Flash::success('Asset saved successfully.');

        return redirect(route('assets.index'));
    }

    /**
     * Display the specified Asset.
     */
    public function show($id)
    {
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            Flash::error('Asset not found');

            return redirect(route('assets.index'));
        }

        return view('assets.show')->with('asset', $asset);
    }

    /**
     * Show the form for editing the specified Asset.
     */
    public function edit($id)
    {
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            Flash::error('Asset not found');

            return redirect(route('assets.index'));
        }

        return view('assets.edit')->with('asset', $asset);
    }

    /**
     * Update the specified Asset in storage.
     */
    public function update($id, UpdateAssetRequest $request)
    {
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            Flash::error('Asset not found');

            return redirect(route('assets.index'));
        }

        $asset = $this->assetRepository->update($request->all(), $id);

        Flash::success('Asset updated successfully.');

        return redirect(route('assets.index'));
    }

    /**
     * Remove the specified Asset from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $asset = $this->assetRepository->find($id);

        if (empty($asset)) {
            Flash::error('Asset not found');

            return redirect(route('assets.index'));
        }

        $this->assetRepository->delete($id);

        Flash::success('Asset deleted successfully.');

        return redirect(route('assets.index'));
    }
}
