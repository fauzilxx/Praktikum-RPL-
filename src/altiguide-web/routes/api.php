<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MountainController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\HikingSessionController;
use App\Http\Controllers\Api\MemberValidationController;

/*
|--------------------------------------------------------------------------
| API Routes — AltiGuide Mobile (Sanctum)
|--------------------------------------------------------------------------
|
| Semua endpoint di bawah prefix /api secara otomatis.
| Public routes bisa diakses tanpa token.
| Protected routes membutuhkan header: Authorization: Bearer {token}
|
*/

// ── Public Routes (tanpa auth) ──────────────────────────────────────────

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Data gunung & rute bisa diakses tanpa login
Route::get('/mountains',      [MountainController::class, 'index']);
Route::get('/mountains/{id}', [MountainController::class, 'show']);
Route::get('/mountains/{id}/weather', [MountainController::class, 'weather']);

Route::get('/routes',      [RouteController::class, 'index']);
Route::get('/routes/{id}', [RouteController::class, 'show']);
Route::get('/routes/{id}/weather', [RouteController::class, 'weather']);

// ── Protected Routes (perlu Bearer token) ───────────────────────────────

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user',    [AuthController::class, 'user']);

    // Transaksi
    Route::get('/transactions',       [TransactionController::class, 'index']);
    Route::post('/transactions',      [TransactionController::class, 'store']);
    Route::get('/transactions/{id}',  [TransactionController::class, 'show']);
    Route::get('/transactions/{id}/pdf', [TransactionController::class, 'downloadPdf']);

    // Validasi Pemesanan Pendaki
    Route::post('/validate-nik', [MemberValidationController::class, 'validateNik']);

    // Sesi Hiking
    Route::get('/hiking-sessions',       [HikingSessionController::class, 'index']);
    Route::post('/hiking-sessions',      [HikingSessionController::class, 'store']);
    Route::get('/hiking-sessions/{id}',  [HikingSessionController::class, 'show']);
});

// ── Webhook Midtrans (WAJIB DAFTAR AUTH-Sanctum/Token) ───────────
Route::post('/midtrans/callback', [TransactionController::class, 'callback']);

// ── API Admin / Basecamp (Sistem Penjagaan & Scan Tiket) ───────────
Route::middleware(['auth:sanctum'])->prefix('v1/admin/checkin')->group(function () {
    Route::get('/scan/{order_id}', [\App\Http\Controllers\Api\Admin\CheckinController::class, 'scan']);
    Route::put('/status/{order_id}', [\App\Http\Controllers\Api\Admin\CheckinController::class, 'updateStatus']);
});
