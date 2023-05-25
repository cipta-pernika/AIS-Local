<?php

use App\Http\Controllers\DataloggerController;
use App\Http\Controllers\HelperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('aisdata', [HelperController::class, 'aisdata']);

Route::apiResource('dataloggers', DataloggerController::class);
Route::get('aisdata', [HelperController::class, 'getaisdata']);
