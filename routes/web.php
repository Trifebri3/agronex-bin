<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\IoTDataController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\SoilDashboardController;
use App\Http\Controllers\WaterDashboardController;
use App\Http\Controllers\WeatherDashboardController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\ArController;

/*
|--------------------------------------------------------------------------
| Web Routes - denrawit x agronex
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('petani.auth')->group(function () {
    // Main Farmer Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/action-plan/check', [DashboardController::class, 'checkActionPlan'])->name('dashboard.check-action-plan');

    // IoT Data Module
    Route::prefix('iot')->name('iot.')->group(function () {
        Route::get('/', [IoTDataController::class, 'index'])->name('index');
        // Kualitas Air Detail
        Route::get('/water-detail', [IoTDataController::class, 'waterDetail'])->name('water.detail');
        Route::get('/water/download', [IoTDataController::class, 'waterDownload'])->name('water.download');
        
        // Kualitas Tanah (SoilSense)
        Route::get('/soilsense', [IoTDataController::class, 'soilDetail'])->name('soilsense.detail');
        Route::get('/soilsense/download', [IoTDataController::class, 'soilDownload'])->name('soilsense.download');

        // TerraNIR (Coming Soon)
        Route::get('/terranir', [IoTDataController::class, 'terranirDetail'])->name('terranir.detail');
        
        Route::get('/weather-detail', [IoTDataController::class, 'weatherDetail'])->name('weather.detail');
        Route::get('/weather-detail/download', [IoTDataController::class, 'weatherDownload'])->name('weather.download');
        
        // Legacy routes under IoT
        Route::prefix('soil')->name('soil.')->group(function () {
            Route::get('/', [SoilDashboardController::class, 'index'])->name('dashboard');
            Route::get('/latest', [SoilDashboardController::class, 'latest'])->name('latest');
            Route::get('/history', [SoilDashboardController::class, 'history'])->name('history');
        });

        Route::prefix('water')->name('water.')->group(function () {
            Route::get('/', [WaterDashboardController::class, 'index'])->name('dashboard');
            Route::get('/latest', [WaterDashboardController::class, 'latest'])->name('latest');
            Route::get('/history', [WaterDashboardController::class, 'history'])->name('history');
        });

        Route::prefix('weather')->name('weather.')->group(function () {
            Route::get('/', [WeatherDashboardController::class, 'index'])->name('dashboard');
            Route::get('/latest', [WeatherDashboardController::class, 'latest'])->name('latest');
            Route::get('/history', [WeatherDashboardController::class, 'history'])->name('history');
        });
    });

    // AI Diagnosis Module
    Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
        Route::get('/', [DiagnosisController::class, 'index'])->name('index');
        Route::post('/analyze', [DiagnosisController::class, 'analyze'])->name('analyze');
    });

    // AI Chatbot Module
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::post('/send', [ChatController::class, 'send'])->name('send');
    });

    // LAB Module
    Route::prefix('lab')->name('lab.')->group(function () {
        Route::get('/', [LabController::class, 'index'])->name('index');
        Route::post('/check', [LabController::class, 'check'])->name('check');
    });

    // AR Module
    Route::prefix('ar')->name('ar.')->group(function () {
        Route::get('/', [ArController::class, 'index'])->name('index');
    });
});

// Admin Backdoor
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
});

// Legacy Hub (if needed)
Route::get('/hub', [HubController::class, 'index'])->name('hub');
Route::get('/hub/status', [HubController::class, 'status'])->name('hub.status');
Route::get('/hub/simulate', [HubController::class, 'simulate'])->name('hub.simulate');

use App\Http\Controllers\AutomationController;
Route::get('/automation', [AutomationController::class, 'index'])->name('automation.index');
Route::post('/automation/config', [AutomationController::class, 'updateConfig'])->name('automation.config');
Route::post('/automation/command', [AutomationController::class, 'sendCommand'])->name('automation.command');
