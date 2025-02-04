<?php

namespace App\Http\Controllers\Api;

use App\Models\MuatanTarif;
use Illuminate\Http\Request;
use App\Http\Requests\MuatanTarifRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MuatanTarifResource;

class MuatanTarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $muatanTarifs = MuatanTarif::paginate();

        return MuatanTarifResource::collection($muatanTarifs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MuatanTarifRequest $request): MuatanTarif
    {
        return MuatanTarif::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(MuatanTarif $muatanTarif): MuatanTarif
    {
        return $muatanTarif;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MuatanTarifRequest $request, MuatanTarif $muatanTarif): MuatanTarif
    {
        $muatanTarif->update($request->validated());

        return $muatanTarif;
    }

    public function destroy(MuatanTarif $muatanTarif): Response
    {
        $muatanTarif->delete();

        return response()->noContent();
    }
}
