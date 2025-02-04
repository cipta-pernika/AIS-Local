<?php

namespace App\Http\Controllers\Api;

use App\Models\Muatan;
use Illuminate\Http\Request;
use App\Http\Requests\MuatanRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MuatanResource;

class MuatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $muatans = Muatan::paginate();

        return MuatanResource::collection($muatans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MuatanRequest $request): Muatan
    {
        return Muatan::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Muatan $muatan): Muatan
    {
        return $muatan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MuatanRequest $request, Muatan $muatan): Muatan
    {
        $muatan->update($request->validated());

        return $muatan;
    }

    public function destroy(Muatan $muatan): Response
    {
        $muatan->delete();

        return response()->noContent();
    }
}
