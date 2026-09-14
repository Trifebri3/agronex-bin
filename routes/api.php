<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoilDataController;
use App\Http\Controllers\WaterDataController;
use App\Http\Controllers\WeatherDataController;
use App\Http\Controllers\HubController;

/*
|--------------------------------------------------------------------------
| API Routes - IoT Sensor Ingestion & Telemetry Data
|--------------------------------------------------------------------------
|
| All routes here are automatically prefixed with '/api'.
| Mikrokontroler (ESP32, Arduino, LoRa, Raspberry Pi) dapat langsung
| mengirim data menggunakan POST atau mengambil data dengan GET.
|
*/

// ==========================================
// 1. SOIL MONITORING SENSORS (Tanah)
// ==========================================
Route::post('/soil-data', [SoilDataController::class, 'store']);
Route::get('/soil-data', [SoilDataController::class, 'index']);
Route::get('/soil-data/latest', [SoilDataController::class, 'latest']);
Route::get('/soil-data/history', [SoilDataController::class, 'history']);

// ==========================================
// 2. WATER QUALITY SENSORS (Kualitas Air)
// ==========================================
Route::post('/water-data', [WaterDataController::class, 'store']);
Route::get('/water-data', [WaterDataController::class, 'index']);
Route::get('/water-data/latest', [WaterDataController::class, 'latest']);
Route::get('/water-data/history', [WaterDataController::class, 'latest']); // alias
Route::get('/water-data/history-list', [WaterDataController::class, 'index']);

// ==========================================
// 3. WEATHER MONITORING SENSORS (Cuaca)
// ==========================================
Route::post('/weather-data', [WeatherDataController::class, 'store']);
Route::get('/weather-data', [WeatherDataController::class, 'index']);
Route::get('/weather-data/latest', [WeatherDataController::class, 'latest']);
Route::get('/weather-data/history', [WeatherDataController::class, 'history']);

// ==========================================
// 4. HUB TELEMETRY & SIMULATOR
// ==========================================
Route::get('/hub-status', [HubController::class, 'status']);
Route::post('/simulate', [HubController::class, 'simulate']);
Route::get('/simulate', [HubController::class, 'simulate']);