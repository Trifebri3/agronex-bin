<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HubController;
use App\Http\Controllers\SoilDashboardController;
use App\Http\Controllers\WaterDashboardController;
use App\Http\Controllers\WeatherDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Unified Multi-Dashboard Monitoring Hub
|--------------------------------------------------------------------------
*/

// 1. Landing Hub & Selection Portal
Route::get('/', [HubController::class, 'index'])->name('hub');
Route::get('/hub/status', [HubController::class, 'status'])->name('hub.status');
Route::get('/hub/simulate', [HubController::class, 'simulate'])->name('hub.simulate');

// 2. Soil Monitoring Dashboard
Route::prefix('soil')->name('soil.')->group(function () {
    Route::get('/', [SoilDashboardController::class, 'index'])->name('dashboard');
    Route::get('/latest', [SoilDashboardController::class, 'latest'])->name('latest');
    Route::get('/history', [SoilDashboardController::class, 'history'])->name('history');
});

// 3. Water Quality Monitoring Dashboard
Route::prefix('water')->name('water.')->group(function () {
    Route::get('/', [WaterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/latest', [WaterDashboardController::class, 'latest'])->name('latest');
    Route::get('/history', [WaterDashboardController::class, 'history'])->name('history');
});

// 4. Weather Monitoring Dashboard
Route::prefix('weather')->name('weather.')->group(function () {
    Route::get('/', [WeatherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/latest', [WeatherDashboardController::class, 'latest'])->name('latest');
    Route::get('/history', [WeatherDashboardController::class, 'history'])->name('history');
});
