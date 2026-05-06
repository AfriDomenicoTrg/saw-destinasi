<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\SAWController;
use App\Http\Controllers\Public\RekomendasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// PUBLIC ROUTES (Tanpa Login - Untuk User)
// ==========================================
Route::get('/', [RekomendasiController::class, 'index'])->name('public.index');
Route::post('/calculate', [RekomendasiController::class, 'calculate'])->name('public.calculate');
Route::get('/result', [RekomendasiController::class, 'result'])->name('public.result');

// ==========================================
// GUEST ROUTES (Belum Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// ==========================================
// AUTH ROUTES (Sudah Login - Umum)
// ==========================================
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// ADMIN ROUTES (Harus Login & Role Admin)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Wisata CRUD
    Route::resource('wisata', WisataController::class);

    // Kriteria CRUD
    Route::resource('kriteria', KriteriaController::class)->parameters(['kriteria' => 'kriteria']);
    Route::get('/kriteria/total-bobot', [KriteriaController::class, 'getTotalBobot'])->name('kriteria.total-bobot');

    // Penilaian CRUD (Admin bisa melihat/mengelola penilaian jika diperlukan)
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::get('/penilaian/wisata/{wisata}', [PenilaianController::class, 'show'])->name('penilaian.show');

    // SAW Calculation (Admin bisa melihat hasil perhitungan)
    Route::get('/saw/calculate', [SAWController::class, 'calculate'])->name('saw.calculate');
    Route::get('/ranking', [SAWController::class, 'ranking'])->name('ranking');
});

// ==========================================
// FALLBACK ROUTE (Redirect ke halaman yang sesuai)
// ==========================================
Route::fallback(function () {
    // Jika sudah login sebagai admin, redirect ke admin dashboard
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    // Jika belum login, redirect ke halaman public
    return redirect()->route('public.index');
});
