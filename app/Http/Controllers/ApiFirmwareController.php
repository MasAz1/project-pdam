<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Firmware;
use App\Models\Device;
use App\Models\FirmwareLog;
use Illuminate\Support\Facades\Storage;

class ApiFirmwareController extends Controller
{
	// Endpoint untuk mengecek apakah ada firmware baru
	public function check(Request $request)
	{
		$project = $request->query('project');
		$currentVersion = $request->query('version');
		$deviceName = $request->query('device');

		if (!$deviceName || !$project) {
			return response()->json(['error' => 'Invalid device or project'], 400);
		}

		$device = Device::firstOrCreate(
			['name' => $deviceName, 'project' => $project],
			['last_seen' => now()]
		);

		$device->update(['last_seen' => now()]);

		$latest = Firmware::where('project', $project)->orderByDesc('created_at')->first();

		if (!$latest || $latest->version === $currentVersion) {
			return response()->json(['update' => false]);
		}

		return response()->json([
			'update' => true,
			'version' => $latest->version,
			'url' => url('/api/firmware/download/' . $latest->id . '?device=' . $device->name),
		]);
	}

	// Endpoint untuk download firmware
	public function download($id, Request $request)
	{
		$firmware = Firmware::findOrFail($id);
		$deviceName = $request->query('device');

		if (!$deviceName) {
			return response()->json(['error' => 'Device name required'], 400);
		}

		$device = Device::where('name', $deviceName)
			->where('project', $firmware->project)
			->first();

		if (!$device) {
			return response()->json(['error' => 'Device not registered'], 404);
		}

		// Update firmware version di tabel devices
		$device->update([
			'firmware' => $firmware->version,
			'firmware_updated_at' => now(),
		]);

		return Storage::download($firmware->file_path);
	}
}
