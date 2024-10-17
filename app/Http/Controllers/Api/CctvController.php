<?php

namespace App\Http\Controllers\Api;

use App\Models\Cctv;
use Illuminate\Http\Request;
use App\Http\Requests\CctvRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CctvResource;

class CctvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get terminal_id from the request
        $terminalIds = $request->query('terminal_id', []);

        // Convert terminalIds to an array, even if it's a single value or empty
        if (!is_array($terminalIds)) {
            $terminalIds = [$terminalIds];
        }

        // Filter only if terminal_id is provided and not empty
        $query = Cctv::query();

        if (!empty($terminalIds)) {
            // Ensure filtering only occurs if terminal_id is not empty
            $query->whereIn('terminal_id', $terminalIds);
        }

        // Paginate the results
        $cctvs = $query->paginate(20);

        // Return the paginated collection
        return CctvResource::collection($cctvs);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CctvRequest $request): Cctv
    {
        return Cctv::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Cctv $cctv): Cctv
    {
        return $cctv;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CctvRequest $request, Cctv $cctv): Cctv
    {
        $cctv->update($request->validated());

        return $cctv;
    }

    public function destroy(Cctv $cctv): Response
    {
        $cctv->delete();

        return response()->noContent();
    }
}
