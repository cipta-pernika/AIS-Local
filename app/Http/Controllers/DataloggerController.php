<?php

namespace App\Http\Controllers;

use App\Models\Datalogger;
use Illuminate\Http\Request;

class DataloggerController extends Controller
{
    public function index()
    {
        return Datalogger::all();
    }

    public function store(Request $request)
    {
        return Datalogger::create($request->all());
    }

    public function show(Datalogger $datalogger)
    {
        return $datalogger;
    }

    public function update(Request $request, Datalogger $datalogger)
    {
        $datalogger->update($request->all());
        return $datalogger;
    }

    public function destroy(Datalogger $datalogger)
    {
        $datalogger->delete();
        return response()->noContent();
    }
}
