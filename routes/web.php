<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FirmwareController;

// firmware Routes
Route::get('/devices/{device}/firmware/update', [FirmwareController::class, 'showUpdateForm'])->name('firmware.update.form');
Route::post('/firmware/upload/{deviceId}', [FirmwareController::class, 'upload'])->name('firmware.upload');




// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Status & Error Log Routes
Route::get('/device/{id}/sdcard-status', [DeviceController::class, 'sdcardStatus'])->name('device.sdcard.status');
Route::get('/devices/{device}/error-logs', [DeviceController::class, 'errorLogs'])->name('devices.errorLogs');

// Redirect root based on auth
Route::get('/', function () {
	return Auth::check()
		? redirect()->route('dashboard')
		: redirect()->route('login');
});

// Protected Routes (Hanya untuk yang sudah login)
Route::middleware(['auth'])->group(function () {
	// Dashboard
	Route::get('/dashboard', [DeviceController::class, 'dashboard'])->name('dashboard');

	// Devices
	Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
	Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
	Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
	Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
	Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
	Route::get('/devices/{device}/export/pdf', [DeviceController::class, 'exportPdf'])->name('devices.export.pdf');
	Route::get('/devices/{device}/chart-data', [DeviceController::class, 'chartData']);
	Route::patch('/devices/{device}/update-location', [DeviceController::class, 'updateLocation'])->name('devices.update.location');
	Route::get('/devices/{id}', [DeviceController::class, 'show'])->name('devices.show');
});

