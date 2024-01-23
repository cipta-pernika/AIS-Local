<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTerminalRequest;
use App\Http\Requests\UpdateTerminalRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TerminalRepository;
use Illuminate\Http\Request;
use Flash;

class TerminalController extends AppBaseController
{
    /** @var TerminalRepository $terminalRepository*/
    private $terminalRepository;

    public function __construct(TerminalRepository $terminalRepo)
    {
        $this->terminalRepository = $terminalRepo;
    }

    /**
     * Display a listing of the Terminal.
     */
    public function index(Request $request)
    {
        $terminals = $this->terminalRepository->paginate(10);

        return view('terminals.index')
            ->with('terminals', $terminals);
    }

    /**
     * Show the form for creating a new Terminal.
     */
    public function create()
    {
        return view('terminals.create');
    }

    /**
     * Store a newly created Terminal in storage.
     */
    public function store(CreateTerminalRequest $request)
    {
        $input = $request->all();

        $terminal = $this->terminalRepository->create($input);

        Flash::success('Terminal saved successfully.');

        return redirect(route('terminals.index'));
    }

    /**
     * Display the specified Terminal.
     */
    public function show($id)
    {
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            Flash::error('Terminal not found');

            return redirect(route('terminals.index'));
        }

        return view('terminals.show')->with('terminal', $terminal);
    }

    /**
     * Show the form for editing the specified Terminal.
     */
    public function edit($id)
    {
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            Flash::error('Terminal not found');

            return redirect(route('terminals.index'));
        }

        return view('terminals.edit')->with('terminal', $terminal);
    }

    /**
     * Update the specified Terminal in storage.
     */
    public function update($id, UpdateTerminalRequest $request)
    {
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            Flash::error('Terminal not found');

            return redirect(route('terminals.index'));
        }

        $terminal = $this->terminalRepository->update($request->all(), $id);

        Flash::success('Terminal updated successfully.');

        return redirect(route('terminals.index'));
    }

    /**
     * Remove the specified Terminal from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $terminal = $this->terminalRepository->find($id);

        if (empty($terminal)) {
            Flash::error('Terminal not found');

            return redirect(route('terminals.index'));
        }

        $this->terminalRepository->delete($id);

        Flash::success('Terminal deleted successfully.');

        return redirect(route('terminals.index'));
    }
}
