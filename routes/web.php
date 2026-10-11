<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AttendanceController, AuthController, DashboardController, EventController, ParticipantController, ReportController};

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

Route::redirect('/', '/absensi');
Route::get('/absensi', [AttendanceController::class, 'create'])->name('attendance.create');
Route::post('/absensi', [AttendanceController::class, 'store'])->middleware('throttle:20,1')->name('attendance.store');
Route::get('/login', [AuthController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kegiatan', EventController::class)->except('show')->parameters(['kegiatan' => 'event'])->names('events');
    Route::resource('peserta', ParticipantController::class)->except('show')->parameters(['peserta' => 'participant'])->names('participants');
    Route::get('laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('laporan/export', [ReportController::class, 'export'])->name('reports.export');
});
