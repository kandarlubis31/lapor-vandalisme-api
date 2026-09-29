<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\AdminLoginController;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk menampilkan form login dan proses login
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('logout');

// Grup rute yang hanya bisa diakses oleh admin yang sudah login
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', \App\Http\Controllers\Web\Admin\UserController::class);

});