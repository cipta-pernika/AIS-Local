<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\JsonResponse;
class TersusController extends AppBaseController
{
    public function search(Request $request): JsonResponse
    {
        $keyword = $request->input('keyword');
        
        $terminals = Terminal::where('name', 'LIKE', "%{$keyword}%")
            ->skip($request->get('skip', 0))
            ->take($request->get('limit', 10))
            ->get();

        return $this->sendResponse($terminals->toArray(), 'Terminals retrieved successfully');
    }
}
