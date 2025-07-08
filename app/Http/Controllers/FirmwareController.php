<?php

namespace App\Http\Controllers;

use App\Models\DeviceF;
use App\Models\DeviceUpdateHistory;
use App\Models\Firmware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FirmwareController extends Controller
{
	public function upload()
	{
		$firmwares = Firmware::latest()->get();
		return view('firmware.upload', compact('firmwares'));
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'version' => 'required|string|unique:firmwares,version',
			'device_model' => 'required|string|max:255',
			'release_notes' => 'nullable|string',
			'firmware_file' => 'required|file|mimes:bin,hex|max:10240', // Max 10MB
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$file = $request->file('firmware_file');
		$filePath = $file->store('firmwares', 'public');

		Firmware::create([
			'name' => $request->name,
			'version' => $request->version,
			'model' => $request->device_model,
			'release_notes' => $request->release_notes,
			'file_path' => $filePath,
			'file_size' => $file->getSize(),
		]);

		return redirect()->route('firmware.upload')->with('success', 'Firmware uploaded successfully!');
	}

	public function update()
	{
		$firmwares = Firmware::all();
		$deviceGroups = DeviceF::distinct('group')->pluck('group');
		$deviceModels = DeviceF::distinct('model')->pluck('model');

		$devices = DeviceF::with('latestUpdate')
			->when(request('search'), function ($query) {
				$query->where('device_id', 'like', '%' . request('search') . '%')
					->orWhere('name', 'like', '%' . request('search') . '%');
			})
			->when(request('status'), function ($query) {
				$query->whereHas('latestUpdate', function ($subQuery) {
					$subQuery->where('status', request('status'));
				});
			})
			->paginate(10);

		return view('firmware.update', compact('firmwares', 'deviceGroups', 'deviceModels', 'devices'));
	}

	public function processUpdate(Request $request)
	{
		$request->validate([
			'device_group' => 'nullable|string',
			'device_model' => 'nullable|string',
			'firmware_version' => 'required|exists:firmwares,version',
		]);

		$firmware = Firmware::where('version', $request->firmware_version)->first();
		$query = DeviceF::query();

		if ($request->device_group) {
			$query->where('group', $request->device_group);
		}

		if ($request->device_model) {
			$query->where('model', $request->device_model);
		}

		$devices = $query->get();

		foreach ($devices as $device) {
			DeviceUpdateHistory::create([
				'device_id' => $device->id,
				'firmware_id' => $firmware->id,
				'status' => 'pending',
			]);

			$device->update([
				'target_firmware_version' => $firmware->version,
				'status' => 'updating',
			]);
		}

		return redirect()->route('firmware.update')->with('success', 'Firmware update process started for ' . $devices->count() . ' devices!');
	}

	public function download(Firmware $firmware)
	{
		$filePath = storage_path('app/public/' . $firmware->file_path);
		return response()->download($filePath);
	}

	public function destroy(Firmware $firmware)
	{
		Storage::disk('public')->delete($firmware->file_path);
		$firmware->delete();

		return redirect()->route('firmware.upload')->with('success', 'Firmware deleted successfully!');
	}
}
