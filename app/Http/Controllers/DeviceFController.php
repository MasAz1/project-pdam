<?php
// app/Http/Controllers/DeviceController.php
namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceFController extends Controller
{
	public function index()
	{
		$devices = Device::with('latestUpdate')
			->orderBy('last_online_at', 'desc')
			->paginate(10);

		return view('devices.index', compact('devices'));
	}

	public function create()
	{
		return view('devices.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'device_id' => 'required|unique:devices,device_id',
			'name' => 'required|string|max:255',
			'model' => 'required|string|max:255',
			'group' => 'nullable|string|max:255',
		]);

		Device::create($request->only('device_id', 'name', 'model', 'group'));

		return redirect()->route('devices.index')->with('success', 'Device added successfully!');
	}

	public function edit(Device $device)
	{
		return view('devices.edit', compact('device'));
	}

	public function update(Request $request, Device $device)
	{
		$request->validate([
			'device_id' => 'required|unique:devices,device_id,' . $device->id,
			'name' => 'required|string|max:255',
			'model' => 'required|string|max:255',
			'group' => 'nullable|string|max:255',
		]);

		$device->update($request->only('device_id', 'name', 'model', 'group'));

		return redirect()->route('devices.index')->with('success', 'Device updated successfully!');
	}

	public function destroy(Device $device)
	{
		$device->delete();
		return redirect()->route('devices.index')->with('success', 'Device deleted successfully!');
	}
}