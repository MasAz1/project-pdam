<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;


// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/device/{id}/sdcard-status', [DeviceController::class, 'sdcardStatus'])
	->name('device.sdcard.status');

Route::get('/', function () {
	return Auth::check()
		? redirect()->route('dashboard')
		: redirect()->route('login');
});

// Protected Routes (Hanya untuk yang sudah login)
Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [DeviceController::class, 'dashboard'])->name('dashboard');
	Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
	Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
	Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
	Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
	Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
	Route::get('/devices/{device}/download-pdf', [DeviceController::class, 'downloadPdf'])->name('devices.downloadPdf');
});
