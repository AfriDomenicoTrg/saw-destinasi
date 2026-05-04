<?php
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');

