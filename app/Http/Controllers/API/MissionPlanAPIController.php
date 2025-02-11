<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMissionPlanAPIRequest;
use App\Http\Requests\API\UpdateMissionPlanAPIRequest;
use App\Models\MissionPlan;
use App\Repositories\MissionPlanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class MissionPlanAPIController
 */
class MissionPlanAPIController extends AppBaseController
{
    private MissionPlanRepository $missionPlanRepository;

    public function __construct(MissionPlanRepository $missionPlanRepo)
    {
        $this->missionPlanRepository = $missionPlanRepo;
    }

    /**
     * Display a listing of the MissionPlans.
     * GET|HEAD /mission-plans
     */
    public function index(Request $request): JsonResponse
    {
        $missionPlans = $this->missionPlanRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($missionPlans->toArray(), 'Mission Plans retrieved successfully');
    }

    /**
     * Store a newly created MissionPlan in storage.
     * POST /mission-plans
     */
    public function store(CreateMissionPlanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $missionPlan = $this->missionPlanRepository->create($input);

        return $this->sendResponse($missionPlan->toArray(), 'Mission Plan saved successfully');
    }

    /**
     * Display the specified MissionPlan.
     * GET|HEAD /mission-plans/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var MissionPlan $missionPlan */
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            return $this->sendError('Mission Plan not found');
        }

        return $this->sendResponse($missionPlan->toArray(), 'Mission Plan retrieved successfully');
    }

    /**
     * Update the specified MissionPlan in storage.
     * PUT/PATCH /mission-plans/{id}
     */
    public function update($id, UpdateMissionPlanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var MissionPlan $missionPlan */
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            return $this->sendError('Mission Plan not found');
        }

        $missionPlan = $this->missionPlanRepository->update($input, $id);

        return $this->sendResponse($missionPlan->toArray(), 'MissionPlan updated successfully');
    }

    /**
     * Remove the specified MissionPlan from storage.
     * DELETE /mission-plans/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var MissionPlan $missionPlan */
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            return $this->sendError('Mission Plan not found');
        }

        $missionPlan->delete();

        return $this->sendSuccess('Mission Plan deleted successfully');
    }
}
