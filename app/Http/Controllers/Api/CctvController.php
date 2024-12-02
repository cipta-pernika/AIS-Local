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
        // Retrieve terminal_ids from the request
        $terminalIds = $request->query('terminal_id', []);
        // dd($terminalIds);

        // Generate a unique cache key based on the terminal IDs
        $cacheKey = 'cctvs_' . implode('_', $terminalIds);

        // Attempt to retrieve cached data
        $cctv = cache()->remember($cacheKey, now()->addDays(7), function () use ($terminalIds) {
            // Filter by terminal_id if provided
            $query = Cctv::query();

            if (!empty($terminalIds)) {
                // If multiple terminal_ids are provided, filter accordingly
                $query->whereIn('terminal_id', $terminalIds);
            }

            // Return only the first result
            return $query->first();
        });

        if ($cctv) {
            // Manually fetch the terminal name
            $terminal = $cctv->terminal; // Assuming a relationship is defined
            $cctv->terminal_name = $terminal ? $terminal->name : null;
        }

        return new CctvResource($cctv);
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
