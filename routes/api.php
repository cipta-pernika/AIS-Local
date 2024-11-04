<?php

use App\Http\Controllers\AisDataController;
use App\Http\Controllers\Api\DataloggerController;
use App\Http\Controllers\Api\GeofenceController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LocationTypeController;
use App\Http\Controllers\Api\GeofenceTypeController;
use App\Http\Controllers\Api\PelabuhanController;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\Api\AisDataVesselController;
use App\Http\Controllers\Api\TerminalController;
use App\Http\Controllers\Api\CctvController;
use App\Http\Controllers\Api\AisDataPositionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('locations', LocationController::class);
Route::apiResource('location_types', LocationTypeController::class);
Route::apiResource('dataloggers', DataloggerController::class);
Route::apiResource('geofences', GeofenceController::class);
Route::apiResource('geofence_types', GeofenceTypeController::class);
Route::apiResource('pelabuhans', PelabuhanController::class);
Route::apiResource('sensors', SensorController::class);
Route::apiResource('ais_data_vessels', AisDataVesselController::class);
Route::apiResource('tersus', TerminalController::class);
Route::apiResource('cctvs', CctvController::class);

Route::get('tersus/search', [TerminalController::class, 'search']);
Route::get('aisdataunique', [AisDataController::class, 'unique']);
Route::apiResource('ais-data-positions', AisDataPositionController::class);

Route::get('roles', RoleController::class)->name('roles.index');
Route::get('permissions', PermissionController::class)->name('permissions.index');

Route::post('roles', [RoleController::class, 'store'])
    ->name('roles.store');

Route::get('roles/{role}', [RoleController::class, 'show'])
    ->name('roles.show');

Route::match(['put', 'patch'], 'roles/{role}', [RoleController::class, 'update'])
    ->name('roles.update');

Route::delete('roles/{role}', [RoleController::class, 'destroy'])
    ->name('roles.destroy');
