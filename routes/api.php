<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\ReportValidationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\ReportController;

// Rute Publik (Tidak perlu login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute yang Membutuhkan Otentikasi (Harus login)
Route::middleware('auth:sanctum')->group(function () {
    // Rute User Umum
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);

    // Rute CRUD Laporan (milik user sendiri)
    Route::apiResource('reports', ReportController::class);

    // Rute Khusus Admin
    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
        Route::get('/reports/pending', [ReportValidationController::class, 'index']);
        Route::patch('/reports/{report}/validate', [ReportValidationController::class, 'validateReport']);
    });
});