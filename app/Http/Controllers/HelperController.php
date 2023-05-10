<?php

namespace App\Http\Controllers;

use App\Models\Vessel;

class HelperController extends Controller
{
    public function aisdata()
    {
        // Create new Vessel
        $vessel = Vessel::create(request()->only((new Vessel)->getFillable()));

        // Create new Port
        $port = Port::create(request()->only((new Port)->getFillable()));

        // Create new Position
        $position = Position::create(request()->only((new Position)->getFillable()));

        // Create new VesselPort
        $vesselPort = new VesselPort([
            'vessel_id' => $vessel->id,
            'port_id' => $port->id,
            'visit_date' => request()->visit_date,
        ]);
        $vesselPort->save();

        // Return response
        return response()->json([
            'vessel' => $vessel,
            'port' => $port,
            'position' => $position,
            'vessel_port' => $vesselPort,
        ], 201);
    }
}
