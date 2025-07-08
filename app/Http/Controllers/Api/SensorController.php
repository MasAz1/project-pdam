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

        // Buat atau update device
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

        // Jika firmware berubah, update waktu firmware
        if ($device->wasChanged('firmware')) {
            $device->firmware_updated_at = now();
            $device->save();
        }

        // Simpan log sensor
        SensorLog::create([
            'device_id'   => $deviceId,
            'value1'      => $sensorData['value1'] ?? null,
            'value2'      => $sensorData['value2'] ?? null,
            'volume'      => $sensorData['volume'] ?? null,
            'kelembapan'  => $sensorData['kelembapan'] ?? null,
            'suhu'        => $sensorData['suhu'] ?? null,
            'recorded_at' => Carbon::parse($timestamp),
        ]);

        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    // Ambil semua data log
    public function index()
    {
        return response()->json(SensorLog::latest()->limit(100)->get());
    }

    // Ambil satu log terbaru
    public function latest()
    {
        return response()->json(SensorLog::latest()->first());
    }

    // ✅ Ambil info perangkat + log terbaru (untuk frontend refresh otomatis)
    public function show($id)
    {
        $device = Device::with('latestLog')->findOrFail($id);

        return response()->json([
            'device' => [
                'id' => $device->id,
                'name' => $device->name,
                'project' => $device->project,
                'battery' => $device->battery,
                'sdcard' => $device->sdcard,
                'firmware' => $device->firmware,
                'firmware_updated_at' => optional($device->firmware_updated_at)->toIso8601String(),
                'last_seen' => optional($device->last_seen)->toIso8601String(),
            ],
            'latest' => $device->latestLog,
        ]);
    }
}
