<?php

namespace App\Http\Controllers\Api;

use App\Models\Pelabuhan;
use Illuminate\Http\Request;
use App\Http\Requests\PelabuhanRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PelabuhanResource;

class PelabuhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pelabuhans = Pelabuhan::paginate();

        return PelabuhanResource::collection($pelabuhans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PelabuhanRequest $request): Pelabuhan
    {
        return Pelabuhan::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelabuhan $pelabuhan): Pelabuhan
    {
        return $pelabuhan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PelabuhanRequest $request, Pelabuhan $pelabuhan): Pelabuhan
    {
        $pelabuhan->update($request->validated());

        return $pelabuhan;
    }

    public function destroy(Pelabuhan $pelabuhan): Response
    {
        $pelabuhan->delete();

        return response()->noContent();
    }
}
