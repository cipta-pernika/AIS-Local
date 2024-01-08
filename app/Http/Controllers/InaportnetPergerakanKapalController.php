<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInaportnetPergerakanKapalRequest;
use App\Http\Requests\UpdateInaportnetPergerakanKapalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InaportnetPergerakanKapalRepository;
use Illuminate\Http\Request;
use Flash;

class InaportnetPergerakanKapalController extends AppBaseController
{
    /** @var InaportnetPergerakanKapalRepository $inaportnetPergerakanKapalRepository*/
    private $inaportnetPergerakanKapalRepository;

    public function __construct(InaportnetPergerakanKapalRepository $inaportnetPergerakanKapalRepo)
    {
        $this->inaportnetPergerakanKapalRepository = $inaportnetPergerakanKapalRepo;
    }

    /**
     * Display a listing of the InaportnetPergerakanKapal.
     */
    public function index(Request $request)
    {
        $inaportnetPergerakanKapals = $this->inaportnetPergerakanKapalRepository->paginate(10);

        return view('inaportnet_pergerakan_kapals.index')
            ->with('inaportnetPergerakanKapals', $inaportnetPergerakanKapals);
    }

    /**
     * Show the form for creating a new InaportnetPergerakanKapal.
     */
    public function create()
    {
        return view('inaportnet_pergerakan_kapals.create');
    }

    /**
     * Store a newly created InaportnetPergerakanKapal in storage.
     */
    public function store(CreateInaportnetPergerakanKapalRequest $request)
    {
        $input = $request->all();

        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->create($input);

        Flash::success('Inaportnet Pergerakan Kapal saved successfully.');

        return redirect(route('inaportnetPergerakanKapals.index'));
    }

    /**
     * Display the specified InaportnetPergerakanKapal.
     */
    public function show($id)
    {
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            Flash::error('Inaportnet Pergerakan Kapal not found');

            return redirect(route('inaportnetPergerakanKapals.index'));
        }

        return view('inaportnet_pergerakan_kapals.show')->with('inaportnetPergerakanKapal', $inaportnetPergerakanKapal);
    }

    /**
     * Show the form for editing the specified InaportnetPergerakanKapal.
     */
    public function edit($id)
    {
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            Flash::error('Inaportnet Pergerakan Kapal not found');

            return redirect(route('inaportnetPergerakanKapals.index'));
        }

        return view('inaportnet_pergerakan_kapals.edit')->with('inaportnetPergerakanKapal', $inaportnetPergerakanKapal);
    }

    /**
     * Update the specified InaportnetPergerakanKapal in storage.
     */
    public function update($id, UpdateInaportnetPergerakanKapalRequest $request)
    {
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            Flash::error('Inaportnet Pergerakan Kapal not found');

            return redirect(route('inaportnetPergerakanKapals.index'));
        }

        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->update($request->all(), $id);

        Flash::success('Inaportnet Pergerakan Kapal updated successfully.');

        return redirect(route('inaportnetPergerakanKapals.index'));
    }

    /**
     * Remove the specified InaportnetPergerakanKapal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $inaportnetPergerakanKapal = $this->inaportnetPergerakanKapalRepository->find($id);

        if (empty($inaportnetPergerakanKapal)) {
            Flash::error('Inaportnet Pergerakan Kapal not found');

            return redirect(route('inaportnetPergerakanKapals.index'));
        }

        $this->inaportnetPergerakanKapalRepository->delete($id);

        Flash::success('Inaportnet Pergerakan Kapal deleted successfully.');

        return redirect(route('inaportnetPergerakanKapals.index'));
    }
}
