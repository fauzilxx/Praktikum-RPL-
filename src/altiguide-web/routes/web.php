<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\RouteController;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// API Endpoints untuk manajemen artikel rute gunung
Route::prefix('api')->group(function () {
    Route::apiResource('routes', RouteController::class);
});
