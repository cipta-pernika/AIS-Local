<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActivityLogRequest;
use App\Http\Requests\UpdateActivityLogRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ActivityLogRepository;
use Illuminate\Http\Request;
use Flash;

class ActivityLogController extends AppBaseController
{
    /** @var ActivityLogRepository $activityLogRepository*/
    private $activityLogRepository;

    public function __construct(ActivityLogRepository $activityLogRepo)
    {
        $this->activityLogRepository = $activityLogRepo;
    }

    /**
     * Display a listing of the ActivityLog.
     */
    public function index(Request $request)
    {
        $activityLogs = $this->activityLogRepository->paginate(10);

        return view('activity_logs.index')
            ->with('activityLogs', $activityLogs);
    }

    /**
     * Show the form for creating a new ActivityLog.
     */
    public function create()
    {
        return view('activity_logs.create');
    }

    /**
     * Store a newly created ActivityLog in storage.
     */
    public function store(CreateActivityLogRequest $request)
    {
        $input = $request->all();

        $activityLog = $this->activityLogRepository->create($input);

        Flash::success('Activity Log saved successfully.');

        return redirect(route('activityLogs.index'));
    }

    /**
     * Display the specified ActivityLog.
     */
    public function show($id)
    {
        $activityLog = $this->activityLogRepository->find($id);

        if (empty($activityLog)) {
            Flash::error('Activity Log not found');

            return redirect(route('activityLogs.index'));
        }

        return view('activity_logs.show')->with('activityLog', $activityLog);
    }

    /**
     * Show the form for editing the specified ActivityLog.
     */
    public function edit($id)
    {
        $activityLog = $this->activityLogRepository->find($id);

        if (empty($activityLog)) {
            Flash::error('Activity Log not found');

            return redirect(route('activityLogs.index'));
        }

        return view('activity_logs.edit')->with('activityLog', $activityLog);
    }

    /**
     * Update the specified ActivityLog in storage.
     */
    public function update($id, UpdateActivityLogRequest $request)
    {
        $activityLog = $this->activityLogRepository->find($id);

        if (empty($activityLog)) {
            Flash::error('Activity Log not found');

            return redirect(route('activityLogs.index'));
        }

        $activityLog = $this->activityLogRepository->update($request->all(), $id);

        Flash::success('Activity Log updated successfully.');

        return redirect(route('activityLogs.index'));
    }

    /**
     * Remove the specified ActivityLog from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $activityLog = $this->activityLogRepository->find($id);

        if (empty($activityLog)) {
            Flash::error('Activity Log not found');

            return redirect(route('activityLogs.index'));
        }

        $this->activityLogRepository->delete($id);

        Flash::success('Activity Log deleted successfully.');

        return redirect(route('activityLogs.index'));
    }
}
