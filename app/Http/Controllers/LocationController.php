<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Location;
use App\Models\LocationType;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Notifications\DatabaseNotification as DatabaseNotificationModel;
use Illuminate\Support\Facades\Cache;

class LocationController extends AppBaseController
{
    public function notifications(Request $request)
    {
        $perPage = 10; // Number of posts per page
        $page = $request->input('page', 1);

        $posts = DatabaseNotificationModel::orderBy('created_at', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // Calculate the next page number
        $nextPage = $page + 1;

        // Check if there are more posts available for the next page
        $hasMorePosts = DatabaseNotificationModel::count() > $page * $perPage;

        return response()->json([
            'status' => 'success',
            'data' => [
                'posts' => $posts,
                'next_page' => $hasMorePosts ? $nextPage : null
            ]
        ]);
    }


    /** @var LocationRepository $locationRepository*/
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    /**
     * Display a listing of the Location.
     */
    public function index(Request $request)
    {
        $locations = $this->locationRepository->paginate(10);

        return view('locations.index')
            ->with('locations', $locations);
    }

    /**
     * Show the form for creating a new Location.
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created Location in storage.
     */
    public function store(CreateLocationRequest $request)
    {
        $input = $request->all();

        $location = $this->locationRepository->create($input);

        Flash::success('Location saved successfully.');

        return redirect(route('locations.index'));
    }

    /**
     * Display the specified Location.
     */
    public function show($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        return view('locations.show')->with('location', $location);
    }

    /**
     * Show the form for editing the specified Location.
     */
    public function edit($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        return view('locations.edit')->with('location', $location);
    }

    /**
     * Update the specified Location in storage.
     */
    public function update($id, UpdateLocationRequest $request)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        $location = $this->locationRepository->update($request->all(), $id);

        Flash::success('Location updated successfully.');

        return redirect(route('locations.index'));
    }

    /**
     * Remove the specified Location from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        $this->locationRepository->delete($id);

        Flash::success('Location deleted successfully.');

        return redirect(route('locations.index'));
    }

    public function getlocationtype()
    {
        $loctype = Cache::remember('location_types', 10080, function () {
            return LocationType::all();
        });

        return response()->json([
            'success' => true,
            'message' => $loctype,
        ], 200);
    }

    public function getlocation()
    {
        $loctype = Location::with('locationType')->get();

        return response()->json([
            'success' => true,
            'message' => $loctype,
        ], 200);
    }
}
