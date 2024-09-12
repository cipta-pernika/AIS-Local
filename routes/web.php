<?php

use App\Http\Controllers\HelperController;
use App\Http\Controllers\OauthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Redirect::to('/admin');
});

Route::get('dailyreport', [HelperController::class, 'dailyreportprint']);

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', function () {
    return Redirect::to('/admin');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::resource('assets', App\Http\Controllers\AssetController::class);
// Route::resource('trackings', App\Http\Controllers\TrackingController::class);
// Route::resource('mission-plans', App\Http\Controllers\MissionPlanController::class);
// Route::resource('event-trackings', App\Http\Controllers\EventTrackingController::class);
// Route::resource('geofence-types', App\Http\Controllers\GeofenceTypeController::class);
// Route::resource('map-settings', App\Http\Controllers\MapSettingController::class);
// Route::resource('report-geofences', App\Http\Controllers\ReportGeofenceController::class);
// Route::resource('identifications', App\Http\Controllers\IdentificationController::class);
// Route::resource('pelabuhans', App\Http\Controllers\PelabuhanController::class);
// Route::resource('inaportnet-bongkar-muats', App\Http\Controllers\InaportnetBongkarMuatController::class);
// Route::resource('inaportnet-pergerakan-kapals', App\Http\Controllers\InaportnetPergerakanKapalController::class);
// Route::resource('impt-pelayanan-kapals', App\Http\Controllers\ImptPelayananKapalController::class);
// Route::resource('impt-penggunaan-alats', App\Http\Controllers\ImptPenggunaanAlatController::class);
// Route::resource('pbkm-kegiatan-pemanduans', App\Http\Controllers\PbkmKegiatanPemanduanController::class);

Route::get('redirecttoplayback', [HelperController::class, 'redirecttoplayback']);
// Route::resource('terminals', App\Http\Controllers\TerminalController::class);
// Route::resource('locations', App\Http\Controllers\LocationController::class);
Route::get('cekposisi', [HelperController::class, 'cekposisi'])->name('cekposisi');
Route::get('playback', [HelperController::class, 'playback'])->name('playback');
// Route::resource('camera-captures', App\Http\Controllers\CameraCaptureController::class);
// Route::resource('report-geofence-bongkar-muats', App\Http\Controllers\ReportGeofenceBongkarMuatController::class);
// Route::resource('data-mandiri-pelaksanaan-kapals', App\Http\Controllers\DataMandiriPelaksanaanKapalController::class);
// Route::resource('certificates', App\Http\Controllers\CertificateController::class);
// Route::resource('report-geofence-pandus', App\Http\Controllers\ReportGeofencePanduController::class);
// Route::resource('tidak-terjadwals', App\Http\Controllers\TidakTerjadwalController::class);
// Route::resource('pandu-tidak-terjadwals', App\Http\Controllers\PanduTidakTerjadwalController::class);
// Route::resource('bongkar-muat-terlambats', App\Http\Controllers\BongkarMuatTerlambatController::class);
// Route::resource('pandu-terlambats', App\Http\Controllers\PanduTerlambatController::class);
// Route::resource('p-n-b-p-jasa-labuh-kapals', App\Http\Controllers\PNBPJasaLabuhKapalController::class);
// Route::resource('p-n-b-p-jasa-rambu-kapals', App\Http\Controllers\PNBPJasaRambuKapalController::class);
// Route::resource('p-n-b-p-jasa-v-t-s-kapals', App\Http\Controllers\PNBPJasaVTSKapalController::class);
// Route::resource('p-n-b-p-jasa-v-t-s-kapal-asings', App\Http\Controllers\PNBPJasaVTSKapalAsingController::class);
// Route::resource('p-n-b-p-jasa-tambat-kapals', App\Http\Controllers\PNBPJasaTambatKapalController::class);
// Route::resource('pemanduan-kapal-marabahans', App\Http\Controllers\PNBPJasaPemanduanKapalMarabahanController::class);
// Route::resource('pemanduan-kapal-trisaktis', App\Http\Controllers\PNBPJasaPemanduanKapalTrisaktiController::class);
// Route::resource('p-n-b-p-jasa-barangs', App\Http\Controllers\PNBPJasaBarangController::class);
// Route::resource('pengawasan-bongkar-muats', App\Http\Controllers\PNBPJasaPengawasanBongkarMuatController::class);
// Route::resource('bongkar-muat-berbahayas', App\Http\Controllers\PNBPJasaBongkarMuatBerbahayaController::class);
// Route::resource('konsolidasis', App\Http\Controllers\KonsolidasiController::class);
// Route::resource('data-b-u-ps', App\Http\Controllers\DataBUPController::class);
// Route::resource('impt-bongkar-muats', App\Http\Controllers\ImptBongkarMuatController::class);
// Route::resource('pelindo-bongkar-muats', App\Http\Controllers\PelindoBongkarMuatController::class);
// Route::resource('bup-konsesis', App\Http\Controllers\BupKonsesiController::class);
// Route::resource('pkk-assign-histories', App\Http\Controllers\PkkAssignHistoryController::class);
// Route::resource('pkk-histories', App\Http\Controllers\PkkHistoryController::class);

Route::get('loginviasso', [OauthController::class, 'loginviasso']);
Route::get('authorization', [OauthController::class, 'authorization']);
// Route::resource('ais-data-positions', App\Http\Controllers\AisDataPositionController::class);
Route::resource('anomaly-variables', App\Http\Controllers\AnomalyVariableController::class);
Route::resource('ais-data-anomalies', App\Http\Controllers\AisDataAnomalyController::class);