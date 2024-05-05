<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use Flash;

class CertificateController extends AppBaseController
{
    /** @var CertificateRepository $certificateRepository*/
    private $certificateRepository;

    public function __construct(CertificateRepository $certificateRepo)
    {
        $this->certificateRepository = $certificateRepo;
    }

    /**
     * Display a listing of the Certificate.
     */
    public function index(Request $request)
    {
        $certificates = $this->certificateRepository->paginate(10);

        return view('certificates.index')
            ->with('certificates', $certificates);
    }

    /**
     * Show the form for creating a new Certificate.
     */
    public function create()
    {
        return view('certificates.create');
    }

    /**
     * Store a newly created Certificate in storage.
     */
    public function store(CreateCertificateRequest $request)
    {
        $input = $request->all();

        $certificate = $this->certificateRepository->create($input);

        Flash::success('Certificate saved successfully.');

        return redirect(route('certificates.index'));
    }

    /**
     * Display the specified Certificate.
     */
    public function show($id)
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            Flash::error('Certificate not found');

            return redirect(route('certificates.index'));
        }

        return view('certificates.show')->with('certificate', $certificate);
    }

    /**
     * Show the form for editing the specified Certificate.
     */
    public function edit($id)
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            Flash::error('Certificate not found');

            return redirect(route('certificates.index'));
        }

        return view('certificates.edit')->with('certificate', $certificate);
    }

    /**
     * Update the specified Certificate in storage.
     */
    public function update($id, UpdateCertificateRequest $request)
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            Flash::error('Certificate not found');

            return redirect(route('certificates.index'));
        }

        $certificate = $this->certificateRepository->update($request->all(), $id);

        Flash::success('Certificate updated successfully.');

        return redirect(route('certificates.index'));
    }

    /**
     * Remove the specified Certificate from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            Flash::error('Certificate not found');

            return redirect(route('certificates.index'));
        }

        $this->certificateRepository->delete($id);

        Flash::success('Certificate deleted successfully.');

        return redirect(route('certificates.index'));
    }
}
