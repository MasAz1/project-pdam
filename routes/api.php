<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

Route::post('/sensor', [SensorController::class, 'store']);
Route::get('/sensor', [SensorController::class, 'index']);
Route::get('/sensor/latest', [SensorController::class, 'latest']);
