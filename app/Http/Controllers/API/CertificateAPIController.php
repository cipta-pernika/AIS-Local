<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCertificateAPIRequest;
use App\Http\Requests\API\UpdateCertificateAPIRequest;
use App\Models\Certificate;
use App\Repositories\CertificateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CertificateAPIController
 */
class CertificateAPIController extends AppBaseController
{
    private CertificateRepository $certificateRepository;

    public function __construct(CertificateRepository $certificateRepo)
    {
        $this->certificateRepository = $certificateRepo;
    }

    /**
     * Display a listing of the Certificates.
     * GET|HEAD /certificates
     */
    public function index(Request $request): JsonResponse
    {
        $certificates = $this->certificateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($certificates->toArray(), 'Certificates retrieved successfully');
    }

    /**
     * Store a newly created Certificate in storage.
     * POST /certificates
     */
    public function store(CreateCertificateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $certificate = $this->certificateRepository->create($input);

        return $this->sendResponse($certificate->toArray(), 'Certificate saved successfully');
    }

    /**
     * Display the specified Certificate.
     * GET|HEAD /certificates/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Certificate $certificate */
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return $this->sendError('Certificate not found');
        }

        return $this->sendResponse($certificate->toArray(), 'Certificate retrieved successfully');
    }

    /**
     * Update the specified Certificate in storage.
     * PUT/PATCH /certificates/{id}
     */
    public function update($id, UpdateCertificateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Certificate $certificate */
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return $this->sendError('Certificate not found');
        }

        $certificate = $this->certificateRepository->update($input, $id);

        return $this->sendResponse($certificate->toArray(), 'Certificate updated successfully');
    }

    /**
     * Remove the specified Certificate from storage.
     * DELETE /certificates/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Certificate $certificate */
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return $this->sendError('Certificate not found');
        }

        $certificate->delete();

        return $this->sendSuccess('Certificate deleted successfully');
    }
}
