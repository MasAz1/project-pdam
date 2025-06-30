<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorLog;
use App\Models\Device;
use Carbon\Carbon;


class SensorController extends Controller
{
    // Simpan data dari IoT
    public function store(Request $request)
    {
        $deviceData = $request->input('device');
        $sensorData = $request->input('data');
        $timestamp  = $request->input('timestamp') ?? now();

        $deviceId = (int) $deviceData['id'];

        // ✅ Buat atau update device (termasuk last_debug)
        $device = Device::updateOrCreate(
            ['id' => $deviceId],
            [
                'name'        => $deviceData['name'],
                'project'     => $deviceData['project'],
                'firmware'    => $deviceData['firmware'] ?? null,
                'battery'     => $deviceData['battery'] ?? null,
                'sdcard'      => $deviceData['sdcard'] ?? null,
                'last_seen'   => Carbon::parse($timestamp),
                'last_debug'  => $deviceData['last_debug'] ?? null,
                'last_debug_info' => $deviceData['last_debug_info'] ?? null,
            ]
        );

        // ✅ Update waktu firmware jika berubah
        if ($device->wasChanged('firmware')) {
            $device->firmware_updated_at = now();
            $device->save();
        }

        // ✅ Simpan log sensor
        SensorLog::create([
            'device_id'   => $deviceId,
            'value1'      => $sensorData['value1'] ?? null,
            'value2'      => $sensorData['value2'] ?? null,
            'kelembapan'  => $sensorData['kelembapan'] ?? null,
            'suhu'        => $sensorData['suhu'] ?? null,
            'recorded_at' => Carbon::parse($timestamp),
        ]);

        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    // Ambil semua data (maks 100 terbaru)
    public function index()
    {
        return response()->json(SensorLog::latest()->limit(100)->get());
    }

    // Ambil data terbaru satu baris
    public function latest()
    {
        return response()->json(SensorLog::latest()->first());
    }
}
