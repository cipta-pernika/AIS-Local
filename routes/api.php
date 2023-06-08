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
    Route::apiResource('sensors', DataloggerController::class);

    //FE
    Route::get('aisdata', [HelperController::class, 'getaisdata']);
    Route::get('playbackais', [HelperController::class, 'playbackais']);
});

//dari sensor
Route::post('aisdata', [HelperController::class, 'aisdata']);
Route::get('aisdataunique', [HelperController::class, 'aisdataunique']);

//camera
Route::post('camzoomminus', [HelperController::class, 'camzoomminus']);
Route::post('camzoomminuscon', [HelperController::class, 'camzoomminuscon']);
Route::post('camup', [HelperController::class, 'camup']);
Route::post('camupcon', [HelperController::class, 'camupcon']);
Route::post('camzoomplus', [HelperController::class, 'camzoomplus']);
Route::post('camzoompluscon', [HelperController::class, 'camzoompluscon']);
Route::post('camleft', [HelperController::class, 'camleft']);
Route::post('camleftcon', [HelperController::class, 'camleftcon']);
Route::post('camleftup', [HelperController::class, 'camleftup']);
Route::post('camleftupcon', [HelperController::class, 'camleftupcon']);
Route::post('camright', [HelperController::class, 'camright']);
Route::post('camrightup', [HelperController::class, 'camrightup']);
Route::post('camdown', [HelperController::class, 'camdown']);
Route::post('camautopan', [HelperController::class, 'camautopan']);
Route::post('camautopanstop', [HelperController::class, 'camautopanstop']);
Route::post('camstop', [HelperController::class, 'camstop']);
Route::post('camfocusmin', [HelperController::class, 'camfocusmin']);
Route::post('camfocusplus', [HelperController::class, 'camfocusplus']);
Route::post('camfocusstop', [HelperController::class, 'camfocusstop']);
Route::post('camleftdown', [HelperController::class, 'camleftdown']);
Route::post('camrightdown', [HelperController::class, 'camrightdown']);
Route::post('camirismin', [HelperController::class, 'camirismin']);
Route::post('camirisplus', [HelperController::class, 'camirisplus']);
Route::post('camirisstop', [HelperController::class, 'camirisstop']);
Route::post('camwiper', [HelperController::class, 'camwiper']);
Route::post('camstopwiper', [HelperController::class, 'camstopwiper']);
Route::post('cammenu', [HelperController::class, 'cammenu']);
Route::post('camstopzoom', [HelperController::class, 'camstopzoom']);