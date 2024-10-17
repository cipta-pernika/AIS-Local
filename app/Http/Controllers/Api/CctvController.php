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
        // Get terminal_id from the query string
        $terminalIds = $request->query('terminal_id', []);
    
        // Ensure terminalIds is always an array
        if (!is_array($terminalIds)) {
            $terminalIds = [$terminalIds];
        }
    
        // Start building the query
        $query = Cctv::query();
    
        // Apply the terminal_id filter only if terminalIds are provided
        if (!empty($terminalIds)) {
            // Filter based on the terminal_id
            $query->whereIn('terminal_id', $terminalIds);
        }
    
        // Paginate the filtered results
        $cctvs = $query->paginate(20);
    
        // Debugging: Log the SQL query and the terminalIds being used
        \Illuminate\Support\Facades\Log::info('Terminal IDs: ', $terminalIds);
        \Illuminate\Support\Facades\Log::info('SQL Query: ', [$query->toSql()]);
    
        // Return the filtered collection
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
