<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\FrigateObjectTrackingEvent;

class FrigateObjectTrackingEventController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $event = FrigateObjectTrackingEvent::create([
            'event_id' => $request->input('before.id') ?? $request->input('after.id'),
            'camera' => $request->input('before.camera') ?? $request->input('after.camera'),
            'event_type' => $request->input('type'),
            'before_state' => $request->input('before'),
            'after_state' => $request->input('after')
        ]);

        return response()->json([
            'message' => 'Event saved successfully',
            'data' => $event
        ], 201);
    }
}
