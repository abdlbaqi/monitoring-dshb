<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RambuController;
use App\Http\Controllers\MarkaController;
use App\Http\Controllers\GuardrailController;
use App\Http\Controllers\ApillController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JalanController;

/*
|--------------------------------------------------------------------------
| Public Routes (Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Only after login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Jalan - Admin only
    Route::middleware('can:admin-only')->group(function () {
        Route::resource('jalan', JalanController::class);
        Route::resource('users', UserController::class);
    });

    // Rambu
    Route::get('/rambu', [RambuController::class, 'index'])->name('rambu.index');
    Route::get('/rambu/create', [RambuController::class, 'create'])->name('rambu.create');
    Route::get('/rambu/{rambu}', [RambuController::class, 'show'])->name('rambu.show');
    Route::middleware('can:admin-only')->group(function () {

        Route::post('/rambu', [RambuController::class, 'store'])->name('rambu.store');
        Route::get('/rambu/{rambu}/edit', [RambuController::class, 'edit'])->name('rambu.edit');
        Route::put('/rambu/{rambu}', [RambuController::class, 'update'])->name('rambu.update');
        Route::delete('/rambu/{rambu}', [RambuController::class, 'destroy'])->name('rambu.destroy');
    });

    // Marka
    Route::get('/marka', [MarkaController::class, 'index'])->name('marka.index');
    Route::get('/marka/create', [MarkaController::class, 'create'])->name('marka.create');
    Route::get('/marka/{marka}', [MarkaController::class, 'show'])->name('marka.show');
    Route::middleware('can:admin-only')->group(function () {
        
        Route::post('/marka', [MarkaController::class, 'store'])->name('marka.store');
        Route::get('/marka/{marka}/edit', [MarkaController::class, 'edit'])->name('marka.edit');
        Route::put('/marka/{marka}', [MarkaController::class, 'update'])->name('marka.update');
        Route::delete('/marka/{marka}', [MarkaController::class, 'destroy'])->name('marka.destroy');
    });

    // Guardrail
    Route::get('/guardrail', [GuardrailController::class, 'index'])->name('guardrail.index');
    Route::get('/guardrail/create', [GuardrailController::class, 'create'])->name('guardrail.create');
    Route::get('/guardrail/{guardrail}', [GuardrailController::class, 'show'])->name('guardrail.show');
    Route::middleware('can:admin-only')->group(function () {
        
        Route::post('/guardrail', [GuardrailController::class, 'store'])->name('guardrail.store');
        Route::get('/guardrail/{guardrail}/edit', [GuardrailController::class, 'edit'])->name('guardrail.edit');
        Route::put('/guardrail/{guardrail}', [GuardrailController::class, 'update'])->name('guardrail.update');
        Route::delete('/guardrail/{guardrail}', [GuardrailController::class, 'destroy'])->name('guardrail.destroy');
    });

    // APILL
    Route::get('/apill', [ApillController::class, 'index'])->name('apill.index');
    Route::get('/apill/{apill}', [ApillController::class, 'show'])->name('apill.show');
    Route::middleware('can:admin-only')->group(function () {
        Route::get('/apill/create', [ApillController::class, 'create'])->name('apill.create');
        Route::post('/apill', [ApillController::class, 'store'])->name('apill.store');
        Route::get('/apill/{apill}/edit', [ApillController::class, 'edit'])->name('apill.edit');
        Route::put('/apill/{apill}', [ApillController::class, 'update'])->name('apill.update');
        Route::delete('/apill/{apill}', [ApillController::class, 'destroy'])->name('apill.destroy');
    });

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/kinerja', [LaporanController::class, 'kinerja'])->name('laporan.kinerja');
    Route::get('/laporan/detail', [LaporanController::class, 'detail'])->name('laporan.detail');
    Route::get('/laporan/monitoring', [LaporanController::class, 'monitoring'])->name('laporan.monitoring');
});
