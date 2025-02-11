<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MapController;
use App\Http\Controllers\API\TersusController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\DataloggerController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FrigateObjectTrackingEventController;
use App\Http\Controllers\GeofenceController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OauthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SyncController;
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

Route::get('aisdatauniquefe', [HelperController::class, 'aisdatauniquefe']);
Route::get('radardatauniquefe', [HelperController::class, 'radardatauniquefe']);
Route::get('adsbuniquefe', [HelperController::class, 'adsbuniquefe']);

//tablelist
Route::get('aisdatalist', [HelperController::class, 'aisdatalist']);
Route::get('adsbdatalist', [HelperController::class, 'adsbdatalist']);
Route::get('radardatalist', [HelperController::class, 'radardatalist']);

//dari sensor
Route::post('aisstatic', [HelperController::class, 'aisstatic']);
Route::post('aisdatastatic', [HelperController::class, 'aisdatastatic']);
Route::post('aisdata', [HelperController::class, 'aisdata']);
Route::post('adsbdatav2', [HelperController::class, 'adsbdatav2']);
Route::post('adsbdata', [HelperController::class, 'adsbdata']);
Route::post('radardata', [HelperController::class, 'radardata']);
Route::post('radardataspx', [HelperController::class, 'radardataspx']);
Route::post('position', [HelperController::class, 'position']);

Route::post('radararpha', [HelperController::class, 'radararpha']);

Route::post('radarpng', [HelperController::class, 'radarpng']);

//map
Route::post('breadcrumb', [MapController::class, 'breadcrumb']);
Route::post('playback', [MapController::class, 'playback']);
Route::post('checkplayback', [MapController::class, 'checkplayback']);

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


//location
Route::get('getlocationtype', [LocationController::class, 'getlocationtype']);
Route::post('setlocation', [LocationController::class, 'setlocation']);
Route::get('getlocation', [LocationController::class, 'getlocation']);
Route::post('deletelocation', [LocationController::class, 'deletelocation']);

Route::post('dailyreport', [HelperController::class, 'dailyreport']);
Route::get('dailyreportpdf', [HelperController::class, 'dailyreportprint']);
Route::post('dailyreportpdf', [HelperController::class, 'dailyreportprint']);

//geofence
Route::post('setgeofence', [GeofenceController::class, 'setgeofence']);
Route::post('getgeofence', [GeofenceController::class, 'getgeofence']);
Route::post('editgeofence', [GeofenceController::class, 'editgeofence']);
Route::post('deletegeofence', [GeofenceController::class, 'deletegeofence']);
Route::post('totalentries', [GeofenceController::class, 'totalentries']);
Route::post('geofence-analytics', [GeofenceController::class, 'analytics']);

Route::resource('assets', App\Http\Controllers\API\AssetAPIController::class);

Route::resource('trackings', App\Http\Controllers\API\TrackingAPIController::class);

Route::resource('mission-plans', App\Http\Controllers\API\MissionPlanAPIController::class);

Route::resource('event-trackings', App\Http\Controllers\API\EventTrackingAPIController::class);

Route::get('search', [HelperController::class, 'search']);

Route::resource('geofence-types', App\Http\Controllers\API\GeofenceTypeAPIController::class);

Route::get('eventtrackings', [HelperController::class, 'eventtrackings']);

Route::resource('map-settings', App\Http\Controllers\API\MapSettingAPIController::class)
    ->except(['create', 'edit']);

Route::resource('report-geofences', App\Http\Controllers\API\ReportGeofenceAPIController::class)
    ->except(['create', 'edit']);

Route::resource('identifications', App\Http\Controllers\API\IdentificationAPIController::class)
    ->except(['create', 'edit']);


Route::get('inaportnet', [SyncController::class, 'inaportnet']);
Route::get('impt', [SyncController::class, 'impt']);

Route::resource('pelabuhans', App\Http\Controllers\API\PelabuhanAPIController::class);

Route::resource('inaportnet-bongkar-muats', App\Http\Controllers\API\InaportnetBongkarMuatAPIController::class);

Route::resource('inaportnet-pergerakan-kapals', App\Http\Controllers\API\InaportnetPergerakanKapalAPIController::class);

Route::resource('impt-pelayanan-kapals', App\Http\Controllers\API\ImptPelayananKapalAPIController::class);

Route::resource('impt-penggunaan-alats', App\Http\Controllers\API\ImptPenggunaanAlatAPIController::class);

Route::resource('pbkm-kegiatan-pemanduans', App\Http\Controllers\API\PbkmKegiatanPemanduanAPIController::class);

Route::resource('terminals', App\Http\Controllers\API\TerminalAPIController::class);

Route::resource('locations', App\Http\Controllers\API\LocationAPIController::class);

Route::post('cekposisi', [MapController::class, 'cekposisi']);

Route::resource('camera-captures', App\Http\Controllers\API\CameraCaptureAPIController::class)
    ->except(['edit']);

Route::resource('report-geofence-bongkar-muats', App\Http\Controllers\API\ReportGeofenceBongkarMuatAPIController::class)
    ->except(['create', 'edit']);


Route::get('notifications', [LocationController::class, 'notifications']);


Route::resource('data-mandiri-pelaksanaan-kapals', App\Http\Controllers\API\DataMandiriPelaksanaanKapalAPIController::class)
    ->except(['create', 'edit']);
Route::resource('konsolidasi-pelaksanaan-kapals', App\Http\Controllers\API\KonsolidasiPelaksanaanKapalAPIController::class)
    ->except(['create', 'edit']);
Route::post('datamandiripdf', [HelperController::class, 'datamandiripdf']);
Route::get('reportharianpdf', [ReportController::class, 'reportharianpdf']);

Route::resource('certificates', App\Http\Controllers\API\CertificateAPIController::class)
    ->except(['create', 'edit']);

Route::get('summaryreport', [ReportController::class, 'summaryreport']);

Route::get('data-mandiri-pelaksanaan-kapals-dummy', [ReportController::class, 'datamandiri']);


Route::resource('report-geofence-pandus', App\Http\Controllers\API\ReportGeofencePanduAPIController::class)
    ->except(['create', 'edit']);

Route::resource('tidak-terjadwals', App\Http\Controllers\API\TidakTerjadwalAPIController::class)
    ->except(['create', 'edit']);

Route::resource('pandu-tidak-terjadwals', App\Http\Controllers\API\PanduTidakTerjadwalAPIController::class)
    ->except(['create', 'edit']);

Route::resource('bongkar-muat-terlambats', App\Http\Controllers\API\BongkarMuatTerlambatAPIController::class)
    ->except(['create', 'edit']);

Route::resource('pandu-terlambats', App\Http\Controllers\API\PanduTerlambatAPIController::class)
    ->except(['create', 'edit']);

Route::resource('p-n-b-p-jasa-labuh-kapals', App\Http\Controllers\API\PNBPJasaLabuhKapalAPIController::class)
    ->except(['create', 'edit']);

Route::resource('p-n-b-p-jasa-rambu-kapals', App\Http\Controllers\API\PNBPJasaRambuKapalAPIController::class)
    ->except(['create', 'edit']);

Route::resource('p-n-b-p-jasa-v-t-s-kapals', App\Http\Controllers\API\PNBPJasaVTSKapalAPIController::class)
    ->except(['create', 'edit']);

Route::resource('p-n-b-p-jasa-v-t-s-kapal-asings', App\Http\Controllers\API\PNBPJasaVTSKapalAsingAPIController::class)
    ->except(['create', 'edit']);

Route::resource('p-n-b-p-jasa-tambat-kapals', App\Http\Controllers\API\PNBPJasaTambatKapalAPIController::class)
    ->except(['create', 'edit']);

// Route::resource('p-n-b-p-jasa-pemanduan-kapal-marabahans', App\Http\Controllers\API\PNBPJasaPemanduanKapalMarabahanAPIController::class)
//     ->except(['create', 'edit']);

// Route::resource('p-n-b-p-jasa-pemanduan-kapal-trisaktis', App\Http\Controllers\API\PNBPJasaPemanduanKapalTrisaktiAPIController::class)
//     ->except(['create', 'edit']);

Route::resource('p-n-b-p-jasa-barangs', App\Http\Controllers\API\PNBPJasaBarangAPIController::class)
    ->except(['create', 'edit']);

// Route::resource('p-n-b-p-jasa-pengawasan-bongkar-muats', App\Http\Controllers\API\PNBPJasaPengawasanBongkarMuatAPIController::class)
//     ->except(['create', 'edit']);

// Route::resource('p-n-b-p-jasa-bongkar-muat-berbahayas', App\Http\Controllers\API\PNBPJasaBongkarMuatBerbahayaAPIController::class)
//     ->except(['create', 'edit']);

Route::get('konsolidasi', [ReportController::class, 'konsolidasi']);


Route::resource('konsolidasis', App\Http\Controllers\API\KonsolidasiAPIController::class)
    ->except(['create', 'edit']);

Route::resource('data-b-u-ps', App\Http\Controllers\API\DataBUPAPIController::class)
    ->except(['create', 'edit']);


Route::resource('impt-bongkar-muats', App\Http\Controllers\API\ImptBongkarMuatAPIController::class)
    ->except(['create', 'edit']);

Route::resource('pelindo-bongkar-muats', App\Http\Controllers\API\PelindoBongkarMuatAPIController::class)
    ->except(['create', 'edit']);

Route::resource('bup-konsesis', App\Http\Controllers\API\BupKonsesiAPIController::class)
    ->except(['create', 'edit']);

Route::resource('pkk-assign-histories', App\Http\Controllers\API\PkkAssignHistoryAPIController::class)
    ->except(['create', 'edit']);

Route::resource('pkk-histories', App\Http\Controllers\API\PkkHistoryAPIController::class)
    ->except(['create', 'edit']);

// Route::get('authorization', [OauthController::class, 'authorization']);
Route::get('authorization', [OauthController::class, 'loginviasso2']);

Route::get('/ssocallback/fesopbuntut', [OauthController::class, 'handleCallback'])
    ->name('callback.frontend');

// Route::post('/ssocallback/besopbuntut', [OauthController::class, 'handleCallbackBackend'])
//     ->name('callback.backend');

// Route::get('/ssocallback/besopbuntut', [OauthController::class, 'handleCallbackBackendGet'])
//     ->name('callback.backend');
// Route::get('/ssocallback/besopbuntut', [OauthController::class, 'ssocallbackhandler'])
//     ->name('callback.backend');

Route::get('loginviasso', [OauthController::class, 'loginviasso']);

// Route::middleware(['validate.keycloak.token'])->get('checksso', [OauthController::class, 'checkSSO']);
Route::get('checksso', [OauthController::class, 'checkSSO']);
Route::resource('activity-logs', App\Http\Controllers\API\ActivityLogAPIController::class);

Route::post('logout', [OauthController::class, 'logout']);

Route::get('sso-session', [OauthController::class, 'ssosession']);

Route::get('renew-token', [OauthController::class, 'renewToken']);

Route::get('check-token', [OauthController::class, 'checkIsTokenValid']);

Route::get('logout-sso', [OauthController::class, 'logoutsso']);



Route::resource('ais-data-positions', App\Http\Controllers\API\AisDataPositionAPIController::class)
    ->except(['create', 'edit']);

    Route::get('ais-data-position/history-export', [ExportController::class, 'aisdatapositionsexport']);
    Route::get('ais-data-position/vessel-export', [ExportController::class, 'aisdatapositionsexportvessel']);
    Route::get('ais-data-position/kegiatan-export', [ExportController::class, 'aisdatapositionsexportkegiatan']);


Route::resource('anomaly-variables', App\Http\Controllers\API\AnomalyVariableAPIController::class)
    ->except(['create']);

Route::resource('ais-data-anomalies', App\Http\Controllers\API\AisDataAnomalyAPIController::class)
    ->except(['create', 'edit']);

Route::get('diagnostics', [DiagnosticController::class, 'runDiagnostics']);

Route::get('tersus/search', [TersusController::class, 'search']);

Route::resource('geofence-images', App\Http\Controllers\API\GeofenceImageAPIController::class);

Route::resource('activity-logs', App\Http\Controllers\API\ActivityLogAPIController::class)
    ->except(['create', 'edit']);

Route::post('frigate-tracking-events', [FrigateObjectTrackingEventController::class, 'store']);