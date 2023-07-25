<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MapController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\DataloggerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Route::get('playbackais', [HelperController::class, 'playbackais']);
});

//CRUD
Route::apiResource('dataloggers', DataloggerController::class);
Route::apiResource('users', UserController::class);

//FE
Route::get('aisdata', [HelperController::class, 'getaisdata']);
Route::get('livefeed', [HelperController::class, 'livefeed']);

Route::get('mylocation', [HelperController::class, 'mylocation']);

Route::apiResource('sensors', SensorController::class);
Route::post('detailvessel', [HelperController::class, 'detailvessel']);
Route::get('aisdataunique', [HelperController::class, 'aisdataunique']);
Route::get('radardataunique', [HelperController::class, 'radardataunique']);
Route::get('radardatauniquelimit', [HelperController::class, 'radardatauniquelimit']);
Route::get('adsbunique', [HelperController::class, 'adsbunique']);
Route::get('radarimage', [HelperController::class, 'radarimage']);
Route::get('aisdataupdate', [HelperController::class, 'aisdataupdate']);
Route::get('adsbupdate', [HelperController::class, 'adsbupdate']);
Route::get('adsbdataupdate', [HelperController::class, 'adsbupdate']);                   
Route::get('radardataupdate', [HelperController::class, 'radardataupdate']);

//tablelist
Route::get('aisdatalist', [HelperController::class, 'aisdatalist']);
Route::get('adsbdatalist', [HelperController::class, 'adsbdatalist']);
Route::get('radardatalist', [HelperController::class, 'radardatalist']);

//dari sensor
Route::post('aisstatic', [HelperController::class, 'aisstatic']);
Route::post('aisdata', [HelperController::class, 'aisdata']);
Route::post('adsbdatav2', [HelperController::class, 'adsbdatav2']);
Route::post('adsbdata', [HelperController::class, 'adsbdata']);
Route::post('radardata', [HelperController::class, 'radardata']);
Route::post('position', [HelperController::class, 'position']);

Route::post('radararpha', [HelperController::class, 'radararpha']);

Route::post('radarpng', [HelperController::class, 'radarpng']);

//map
Route::post('breadcrumb', [MapController::class, 'breadcrumb']);
Route::post('playback', [MapController::class, 'playback']);

//export
Route::post('exportais', [ExportController::class, 'exportais']);

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


Route::post('updateradarname', [HelperController::class, 'updateradarname']);