<?php

use App\Http\Controllers\DataloggerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HelperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    //CRUD
    Route::apiResource('dataloggers', DataloggerController::class);

    //FE
    Route::get('aisdata', [HelperController::class, 'getaisdata']);
    Route::get('aisdataunique', [HelperController::class, 'aisdataunique']);
});

//dari sensor
Route::post('aisdata', [HelperController::class, 'aisdata']);
