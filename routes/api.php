<?php

use App\Http\Controllers\Api\DataloggerController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LocationTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('locations', LocationController::class);
Route::apiResource('location_types', LocationTypeController::class);
Route::apiResource('dataloggers', DataloggerController::class);
