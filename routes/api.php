<?php

use App\Http\Controllers\AisDataController;
use App\Http\Controllers\Api\DataloggerController;
use App\Http\Controllers\Api\GeofenceController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LocationTypeController;
use App\Http\Controllers\Api\GeofenceTypeController;
use App\Http\Controllers\Api\MuatanController;
use App\Http\Controllers\Api\PelabuhanController;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\Api\AisDataVesselController;
use App\Http\Controllers\Api\TerminalController;
use App\Http\Controllers\Api\CctvController;
use App\Http\Controllers\Api\AisDataPositionController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\MapController;
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
Route::get('report-geofence', [AisDataPositionController::class, 'getEventTracking']);
Route::get('report-geofence-image', [AisDataPositionController::class, 'getEventTrackingImage']);

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


Route::post('playback', [MapController::class, 'playback']);
Route::post('checkplayback', [MapController::class, 'checkplayback']);


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

Route::post('movebylatlng', [HelperController::class, 'movebylatlng']);
Route::post('camset', [HelperController::class, 'camset']);
Route::post('camcall', [HelperController::class, 'camcall']);

Route::apiResource('muatans', MuatanController::class);