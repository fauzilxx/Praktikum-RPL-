<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes — AltiGuide
|--------------------------------------------------------------------------
*/

// ── Halaman publik ──────────────────────────────────────────────────────

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// ── Guest routes (hanya bisa diakses kalau BELUM login) ─────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class, 'create'])->name('login');
    Route::post('/login',    [LoginController::class, 'store']);
    Route::get('/register',  [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Route untuk flow Forgot Password
    Route::get('/forgot-password',           [\App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password/email',    [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetCodeEmail'])->name('password.email');

    // Route Verifikasi Kode OTP
    Route::get('/forgot-password/verify',    [\App\Http\Controllers\Auth\PasswordResetController::class, 'showVerifyCodeForm'])->name('password.verify');
    Route::post('/forgot-password/verify',   [\App\Http\Controllers\Auth\PasswordResetController::class, 'verifyResetCode'])->name('password.verify.post');

    // Route Reset Password (setelah kode OTP divalidasi)
    Route::get('/reset-password',            [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',           [\App\Http\Controllers\Auth\PasswordResetController::class, 'resetPassword'])->name('password.update');
});

// ── User protected routes (harus login sebagai User) ────────────────────

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// ── Admin routes ────────────────────────────────────────────────────────

Route::prefix('admin')->group(function () {

    // Guest admin (belum login sebagai admin)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login',  [AdminLoginController::class, 'create'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'store']);
    });

    // Protected admin (harus login sebagai admin + middleware is_admin)
    Route::middleware(['auth:admin', 'is_admin'])->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');

        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');

        // CMS Manajemen Gunung (Mountain CRUD)
        Route::resource('mountains', \App\Http\Controllers\Admin\MountainController::class)->names([
            'index'   => 'admin.mountains.index',
            'create'  => 'admin.mountains.create',
            'store'   => 'admin.mountains.store',
            'show'    => 'admin.mountains.show',
            'edit'    => 'admin.mountains.edit',
            'update'  => 'admin.mountains.update',
            'destroy' => 'admin.mountains.destroy',
        ]);

        // CMS Manajemen Rute (Rute merupakan child dari Gunung)
        Route::prefix('mountains/{mountain}')->group(function () {
            Route::get('/routes/create', [\App\Http\Controllers\Admin\RouteController::class, 'create'])->name('admin.routes.create');
            Route::post('/routes', [\App\Http\Controllers\Admin\RouteController::class, 'store'])->name('admin.routes.store');
            Route::get('/routes/{route}/edit', [\App\Http\Controllers\Admin\RouteController::class, 'edit'])->name('admin.routes.edit');
            Route::put('/routes/{route}', [\App\Http\Controllers\Admin\RouteController::class, 'update'])->name('admin.routes.update');
            Route::delete('/routes/{route}', [\App\Http\Controllers\Admin\RouteController::class, 'destroy'])->name('admin.routes.destroy');
        });

        // CMS Route Info & Route Waypoints (Child dari Rute)
        Route::prefix('routes/{route}')->group(function () {
            // Informasi Rute (1:1 Relation dengan Rute)
            Route::get('/info/edit', [\App\Http\Controllers\Admin\RouteInfoController::class, 'edit'])->name('admin.routes.info.edit');
            Route::put('/info', [\App\Http\Controllers\Admin\RouteInfoController::class, 'update'])->name('admin.routes.info.update');
            
            // Titik Singgah / Pos / Waypoints (1:M Relation dengan Rute)
            Route::get('/waypoints', [\App\Http\Controllers\Admin\RouteWaypointController::class, 'index'])->name('admin.routes.waypoints.index');
            Route::get('/waypoints/create', [\App\Http\Controllers\Admin\RouteWaypointController::class, 'create'])->name('admin.routes.waypoints.create');
            Route::post('/waypoints', [\App\Http\Controllers\Admin\RouteWaypointController::class, 'store'])->name('admin.routes.waypoints.store');
            Route::get('/waypoints/{waypoint}/edit', [\App\Http\Controllers\Admin\RouteWaypointController::class, 'edit'])->name('admin.routes.waypoints.edit');
            Route::put('/waypoints/{waypoint}', [\App\Http\Controllers\Admin\RouteWaypointController::class, 'update'])->name('admin.routes.waypoints.update');
            Route::delete('/waypoints/{waypoint}', [\App\Http\Controllers\Admin\RouteWaypointController::class, 'destroy'])->name('admin.routes.waypoints.destroy');
        });
    });
});
