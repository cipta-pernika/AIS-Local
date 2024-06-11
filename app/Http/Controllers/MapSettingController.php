<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMapSettingRequest;
use App\Http\Requests\UpdateMapSettingRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MapSettingRepository;
use Illuminate\Http\Request;
use Flash;

class MapSettingController extends AppBaseController
{
    /** @var MapSettingRepository $mapSettingRepository*/
    private $mapSettingRepository;

    public function __construct(MapSettingRepository $mapSettingRepo)
    {
        $this->mapSettingRepository = $mapSettingRepo;
    }

    /**
     * Display a listing of the MapSetting.
     */
    public function index(Request $request)
    {
        $mapSettings = $this->mapSettingRepository->paginate(10);

        return view('map_settings.index')
            ->with('mapSettings', $mapSettings);
    }

    /**
     * Show the form for creating a new MapSetting.
     */
    public function create()
    {
        return view('map_settings.create');
    }

    /**
     * Store a newly created MapSetting in storage.
     */
    public function store(CreateMapSettingRequest $request)
    {
        $input = $request->all();

        $mapSetting = $this->mapSettingRepository->create($input);

        Flash::success('Map Setting saved successfully.');

        return redirect(route('mapSettings.index'));
    }

    /**
     * Display the specified MapSetting.
     */
    public function show($id)
    {
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            Flash::error('Map Setting not found');

            return redirect(route('mapSettings.index'));
        }

        return view('map_settings.show')->with('mapSetting', $mapSetting);
    }

    /**
     * Show the form for editing the specified MapSetting.
     */
    public function edit($id)
    {
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            Flash::error('Map Setting not found');

            return redirect(route('mapSettings.index'));
        }

        return view('map_settings.edit')->with('mapSetting', $mapSetting);
    }

    /**
     * Update the specified MapSetting in storage.
     */
    public function update($id, UpdateMapSettingRequest $request)
    {
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            Flash::error('Map Setting not found');

            return redirect(route('mapSettings.index'));
        }

        $mapSetting = $this->mapSettingRepository->update($request->all(), $id);

        Flash::success('Map Setting updated successfully.');

        return redirect(route('mapSettings.index'));
    }

    /**
     * Remove the specified MapSetting from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mapSetting = $this->mapSettingRepository->find($id);

        if (empty($mapSetting)) {
            Flash::error('Map Setting not found');

            return redirect(route('mapSettings.index'));
        }

        $this->mapSettingRepository->delete($id);

        Flash::success('Map Setting deleted successfully.');

        return redirect(route('mapSettings.index'));
    }
}
