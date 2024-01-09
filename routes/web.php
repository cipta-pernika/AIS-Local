<?php

use App\Http\Controllers\HelperController;
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
Route::resource('geofence-types', App\Http\Controllers\GeofenceTypeController::class);
Route::resource('map-settings', App\Http\Controllers\MapSettingController::class);
Route::resource('report-geofences', App\Http\Controllers\ReportGeofenceController::class);
Route::resource('identifications', App\Http\Controllers\IdentificationController::class);
Route::resource('pelabuhans', App\Http\Controllers\PelabuhanController::class);
Route::resource('inaportnet-bongkar-muats', App\Http\Controllers\InaportnetBongkarMuatController::class);
Route::resource('inaportnet-pergerakan-kapals', App\Http\Controllers\InaportnetPergerakanKapalController::class);
Route::resource('impt-pelayanan-kapals', App\Http\Controllers\ImptPelayananKapalController::class);
Route::resource('impt-penggunaan-alats', App\Http\Controllers\ImptPenggunaanAlatController::class);
Route::resource('pbkm-kegiatan-pemanduans', App\Http\Controllers\PbkmKegiatanPemanduanController::class);