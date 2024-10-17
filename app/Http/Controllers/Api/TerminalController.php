<?php

namespace App\Http\Controllers\Api;

use App\Models\Terminal;
use Illuminate\Http\Request;
use App\Http\Requests\TerminalRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TerminalResource;

class TerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $terminals = Terminal::paginate();

        return TerminalResource::collection($terminals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TerminalRequest $request): Terminal
    {
        return Terminal::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Terminal $terminal): Terminal
    {
        return $terminal;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TerminalRequest $request, Terminal $terminal): Terminal
    {
        $terminal->update($request->validated());

        return $terminal;
    }

    public function destroy(Terminal $terminal): Response
    {
        $terminal->delete();

        return response()->noContent();
    }

    /**
     * Search for terminals by keyword.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $terminals = Terminal::where('name', 'LIKE', "%{$keyword}%")->get();

        // return TerminalResource::collection($terminals);
        return response()->json($terminals);
    }

}
