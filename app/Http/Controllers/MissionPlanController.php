<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMissionPlanRequest;
use App\Http\Requests\UpdateMissionPlanRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MissionPlanRepository;
use Illuminate\Http\Request;
use Flash;

class MissionPlanController extends AppBaseController
{
    /** @var MissionPlanRepository $missionPlanRepository*/
    private $missionPlanRepository;

    public function __construct(MissionPlanRepository $missionPlanRepo)
    {
        $this->missionPlanRepository = $missionPlanRepo;
    }

    /**
     * Display a listing of the MissionPlan.
     */
    public function index(Request $request)
    {
        $missionPlans = $this->missionPlanRepository->paginate(10);

        return view('mission_plans.index')
            ->with('missionPlans', $missionPlans);
    }

    /**
     * Show the form for creating a new MissionPlan.
     */
    public function create()
    {
        return view('mission_plans.create');
    }

    /**
     * Store a newly created MissionPlan in storage.
     */
    public function store(CreateMissionPlanRequest $request)
    {
        $input = $request->all();

        $missionPlan = $this->missionPlanRepository->create($input);

        Flash::success('Mission Plan saved successfully.');

        return redirect(route('missionPlans.index'));
    }

    /**
     * Display the specified MissionPlan.
     */
    public function show($id)
    {
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            Flash::error('Mission Plan not found');

            return redirect(route('missionPlans.index'));
        }

        return view('mission_plans.show')->with('missionPlan', $missionPlan);
    }

    /**
     * Show the form for editing the specified MissionPlan.
     */
    public function edit($id)
    {
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            Flash::error('Mission Plan not found');

            return redirect(route('missionPlans.index'));
        }

        return view('mission_plans.edit')->with('missionPlan', $missionPlan);
    }

    /**
     * Update the specified MissionPlan in storage.
     */
    public function update($id, UpdateMissionPlanRequest $request)
    {
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            Flash::error('Mission Plan not found');

            return redirect(route('missionPlans.index'));
        }

        $missionPlan = $this->missionPlanRepository->update($request->all(), $id);

        Flash::success('Mission Plan updated successfully.');

        return redirect(route('missionPlans.index'));
    }

    /**
     * Remove the specified MissionPlan from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $missionPlan = $this->missionPlanRepository->find($id);

        if (empty($missionPlan)) {
            Flash::error('Mission Plan not found');

            return redirect(route('missionPlans.index'));
        }

        $this->missionPlanRepository->delete($id);

        Flash::success('Mission Plan deleted successfully.');

        return redirect(route('missionPlans.index'));
    }
}
