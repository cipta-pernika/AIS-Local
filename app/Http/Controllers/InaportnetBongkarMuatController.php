<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInaportnetBongkarMuatRequest;
use App\Http\Requests\UpdateInaportnetBongkarMuatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InaportnetBongkarMuatRepository;
use Illuminate\Http\Request;
use Flash;

class InaportnetBongkarMuatController extends AppBaseController
{
    /** @var InaportnetBongkarMuatRepository $inaportnetBongkarMuatRepository*/
    private $inaportnetBongkarMuatRepository;

    public function __construct(InaportnetBongkarMuatRepository $inaportnetBongkarMuatRepo)
    {
        $this->inaportnetBongkarMuatRepository = $inaportnetBongkarMuatRepo;
    }

    /**
     * Display a listing of the InaportnetBongkarMuat.
     */
    public function index(Request $request)
    {
        $inaportnetBongkarMuats = $this->inaportnetBongkarMuatRepository->paginate(10);

        return view('inaportnet_bongkar_muats.index')
            ->with('inaportnetBongkarMuats', $inaportnetBongkarMuats);
    }

    /**
     * Show the form for creating a new InaportnetBongkarMuat.
     */
    public function create()
    {
        return view('inaportnet_bongkar_muats.create');
    }

    /**
     * Store a newly created InaportnetBongkarMuat in storage.
     */
    public function store(CreateInaportnetBongkarMuatRequest $request)
    {
        $input = $request->all();

        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->create($input);

        Flash::success('Inaportnet Bongkar Muat saved successfully.');

        return redirect(route('inaportnetBongkarMuats.index'));
    }

    /**
     * Display the specified InaportnetBongkarMuat.
     */
    public function show($id)
    {
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            Flash::error('Inaportnet Bongkar Muat not found');

            return redirect(route('inaportnetBongkarMuats.index'));
        }

        return view('inaportnet_bongkar_muats.show')->with('inaportnetBongkarMuat', $inaportnetBongkarMuat);
    }

    /**
     * Show the form for editing the specified InaportnetBongkarMuat.
     */
    public function edit($id)
    {
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            Flash::error('Inaportnet Bongkar Muat not found');

            return redirect(route('inaportnetBongkarMuats.index'));
        }

        return view('inaportnet_bongkar_muats.edit')->with('inaportnetBongkarMuat', $inaportnetBongkarMuat);
    }

    /**
     * Update the specified InaportnetBongkarMuat in storage.
     */
    public function update($id, UpdateInaportnetBongkarMuatRequest $request)
    {
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            Flash::error('Inaportnet Bongkar Muat not found');

            return redirect(route('inaportnetBongkarMuats.index'));
        }

        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->update($request->all(), $id);

        Flash::success('Inaportnet Bongkar Muat updated successfully.');

        return redirect(route('inaportnetBongkarMuats.index'));
    }

    /**
     * Remove the specified InaportnetBongkarMuat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $inaportnetBongkarMuat = $this->inaportnetBongkarMuatRepository->find($id);

        if (empty($inaportnetBongkarMuat)) {
            Flash::error('Inaportnet Bongkar Muat not found');

            return redirect(route('inaportnetBongkarMuats.index'));
        }

        $this->inaportnetBongkarMuatRepository->delete($id);

        Flash::success('Inaportnet Bongkar Muat deleted successfully.');

        return redirect(route('inaportnetBongkarMuats.index'));
    }
}
