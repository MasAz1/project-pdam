<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Firmware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FirmwareController extends Controller
{
    public function showUpdateForm($deviceId)
    {
        $device = Device::findOrFail($deviceId);
        $firmwares = Firmware::where('file_path', 'like', "%$device->name$device->project%")
            ->orderBy('created_at', 'desc')
            ->get();
        return view('firmware.update', compact('device', 'firmwares'));
    }

    public function upload(Request $request, $deviceId)
    {
        $request->validate([
            'version' => 'required|string',
            'file' => 'required|file',
        ]);

        if (Firmware::where('version', $request->version)->exists()) {
            return back()->withErrors(['version' => 'Versi firmware ini sudah ada.']);
        }

        // Pastikan hanya .bin yang diterima
        if ($request->file('file')->getClientOriginalExtension() !== 'bin') {
            return back()->withErrors(['file' => 'File harus berekstensi .bin']);
        }

        $device = Device::findOrFail($deviceId);
        // Simpan file ke storage/app/firmwares/firmware_{timestamp}.bin
        $fileName = $device->name . $device->project . '_v' . $request->version . '.bin';
        $path = $request->file('file')->storeAs('firmwares', $fileName);

        // Simpan ke database
        Firmware::create([
            'version' => $request->version,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Firmware berhasil diunggah.');
    }
}
