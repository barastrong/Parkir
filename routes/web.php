<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Parkir\jenisKendaraanController;
use App\Http\Controllers\Parkir\KendaraanMasukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Parkir\RiwayatKeluarController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('riwayat-keluar')->name('riwayatkeluar.')->group(function () {
        Route::get('/', [RiwayatKeluarController::class, 'index'])->name('dashboard');
        Route::post('/', [RiwayatKeluarController::class, 'store'])->name('store');
    });
    
    Route::prefix('kendaraan-masuk')->name('kendaraanmasuk.')->group(function () {
        Route::get('/', [KendaraanMasukController::class, 'index'])->name('dashboard');
        Route::post('/', [KendaraanMasukController::class, 'store'])->name('store');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('dashboard');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('parkir')->name('parkir.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardParkir'])->name('dashboard');
        Route::get('/jenis-kendaraan', [JenisKendaraanController::class, 'index'])->name('jenis-kendaraan.index');
        Route::post('/jenis-kendaraan', [JenisKendaraanController::class, 'store'])->name('jenis-kendaraan.store');
        Route::put('/jenis-kendaraan/{id}', [JenisKendaraanController::class, 'update'])->name('jenis-kendaraan.update');
        Route::delete('/jenis-kendaraan/{id}', [JenisKendaraanController::class, 'destroy'])->name('jenis-kendaraan.destroy');
        Route::get('/jenis-kendaraan/slot', [JenisKendaraanController::class, 'slot'])->name('slot');
        Route::post('/jenis-kendaraan/slot', [JenisKendaraanController::class, 'slotStore'])->name('slotStore');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
