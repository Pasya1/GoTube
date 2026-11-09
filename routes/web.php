<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatatanKhususTabungController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanKerusakanTabungController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TabungController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;
use App\Models\LaporanKerusakanTabung;
use App\Http\Controllers\MonitoringTabungController;
use App\Http\Controllers\SalesController;

// Route untuk menampilkan form login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Route untuk memproses login
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Route untuk logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN MENAMPILKAN HALAMAN
Route::middleware('auth')->group(function () {
    Route::get('/outlet/search-location', [OutletController::class, 'searchLocation'])
        ->name('outlet.search-location');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/sales', [SalesController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/create', [SalesController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SalesController::class, 'store'])
        ->name('sales.store');

    Route::delete('/sales/{sale}', [SalesController::class, 'destroy'])
        ->name('sales.destroy');

    Route::get('/sales/export', [SalesController::class, 'export'])
        ->name('sales.export');


    Route::get('/monitoring-tabung', [
        MonitoringTabungController::class,
        'index'
    ])->name('monitoring.tabung');

    Route::post(
        '/catatan-khusus-tabung',
        [CatatanKhususTabungController::class, 'store']
    )->name('catatan-khusus-tabung.store');

    Route::delete(
        '/catatan-khusus-tabung/{catatanKhususTabung}',
        [CatatanKhususTabungController::class, 'destroy']
    )->name('catatan-khusus-tabung.destroy');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
        Route::post('/password/{id}', [UserController::class, 'changePassword'])->name('users.password');
    });

    Route::get('/tabung/download-qr/{kode}', [TabungController::class, 'downloadQR'])
        ->name('tabung.downloadQR');
    Route::get('/tabung/download-pdf', [TabungController::class, 'downloadPDF'])
        ->name('tabung.downloadPDF');
    Route::get('/generate-qr', [TabungController::class, 'generateQRMassal']);
    Route::put('/tabung/{id}/catatan', [TabungController::class, 'updateCatatan'])
        ->name('tabung.updateCatatan');
    Route::put('/tabung/{id}/catatan', [TabungController::class, 'editCatatan'])
        ->name('tabung.updateCatatan');
    Route::resource('tabung', TabungController::class)->except(['show']);


    // routes/web.php
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::get('/tracking/{id}', [TrackingController::class, 'show'])->name('tracking.show');
    Route::put('tracking/{id}/status', [TrackingController::class, 'updateStatus'])->name('tracking.updateStatus');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.lihat');
    Route::get('/history/export/excel', [HistoryController::class, 'exportExcel'])->name('history.export.excel');
    Route::get('/history/export/pdf', [HistoryController::class, 'exportPDF'])->name('history.export.pdf');
    Route::post(
        '/laporan-kerusakan',
        [LaporanKerusakanTabungController::class, 'store']
    )->name('laporan.store');

    Route::get('/laporan-kerusakan', [LaporanKerusakanTabungController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan-kerusakan/{id}', [LaporanKerusakanTabungController::class, 'show'])
        ->name('laporan.show');

    Route::put('/laporan-kerusakan/{id}', [LaporanKerusakanTabungController::class, 'updateStatus'])
        ->name('laporan.update');

    Route::delete('/laporan-kerusakan/{id}', [LaporanKerusakanTabungController::class, 'destroy'])
        ->name('laporan.destroy');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    Route::resource('outlet', OutletController::class)->except(['show']);

    Route::post('/pengiriman/store', [PengirimanController::class, 'store'])->name('pengiriman.store');
    Route::post('/pengiriman/{id}/status', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');
});
