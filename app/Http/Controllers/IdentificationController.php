<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdentificationRequest;
use App\Http\Requests\UpdateIdentificationRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\IdentificationRepository;
use Illuminate\Http\Request;
use Flash;

class IdentificationController extends AppBaseController
{
    /** @var IdentificationRepository $identificationRepository*/
    private $identificationRepository;

    public function __construct(IdentificationRepository $identificationRepo)
    {
        $this->identificationRepository = $identificationRepo;
    }

    /**
     * Display a listing of the Identification.
     */
    public function index(Request $request)
    {
        $identifications = $this->identificationRepository->paginate(10);

        return view('identifications.index')
            ->with('identifications', $identifications);
    }

    /**
     * Show the form for creating a new Identification.
     */
    public function create()
    {
        return view('identifications.create');
    }

    /**
     * Store a newly created Identification in storage.
     */
    public function store(CreateIdentificationRequest $request)
    {
        $input = $request->all();

        $identification = $this->identificationRepository->create($input);

        Flash::success('Identification saved successfully.');

        return redirect(route('identifications.index'));
    }

    /**
     * Display the specified Identification.
     */
    public function show($id)
    {
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            Flash::error('Identification not found');

            return redirect(route('identifications.index'));
        }

        return view('identifications.show')->with('identification', $identification);
    }

    /**
     * Show the form for editing the specified Identification.
     */
    public function edit($id)
    {
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            Flash::error('Identification not found');

            return redirect(route('identifications.index'));
        }

        return view('identifications.edit')->with('identification', $identification);
    }

    /**
     * Update the specified Identification in storage.
     */
    public function update($id, UpdateIdentificationRequest $request)
    {
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            Flash::error('Identification not found');

            return redirect(route('identifications.index'));
        }

        $identification = $this->identificationRepository->update($request->all(), $id);

        Flash::success('Identification updated successfully.');

        return redirect(route('identifications.index'));
    }

    /**
     * Remove the specified Identification from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $identification = $this->identificationRepository->find($id);

        if (empty($identification)) {
            Flash::error('Identification not found');

            return redirect(route('identifications.index'));
        }

        $this->identificationRepository->delete($id);

        Flash::success('Identification deleted successfully.');

        return redirect(route('identifications.index'));
    }
}
