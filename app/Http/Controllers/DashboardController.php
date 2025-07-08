<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Firmware;
use App\Models\DeviceUpdateHistory;

class DashboardController extends Controller
{
	public function index()
	{
		$totalDevices = Device::count();
		$onlineDevices = Device::where('status', 'online')->count();
		$offlineDevices = Device::where('status', 'offline')->count();

		$pendingUpdates = Device::whereNotNull('target_firmware_version')
			->whereColumn('current_firmware_version', '!=', 'target_firmware_version')
			->count();

		return view('dashboard', compact(
			'totalDevices',
			'onlineDevices',
			'offlineDevices',
			'firmwareVersions',
			'latestFirmware',
			'pendingUpdates',
			'recentActivities'
		));
	}
}