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
    // public function index(Request $request)
    // {
    //     $cctvs = Cctv::paginate();

    //     return CctvResource::collection($cctvs);
    // }
    public function index(Request $request)
{
    $query = Cctv::query();

    if (isset($request->terminal_id)) {
        $query->whereIn('terminal_id', $request->terminal_id);
    }

    $cctvs = $query->paginate();

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
