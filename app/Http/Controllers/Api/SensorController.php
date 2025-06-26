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

        $deviceId = (int) $deviceData['id'];
        $deviceName = $deviceData['name'];
        $deviceProject = (int) $deviceData['project'];

        // 🟢 Tambah device otomatis jika belum ada
        $device = Device::firstOrCreate(
            ['id' => $deviceId],
            [
                'name' => $deviceName,
                'project' => $deviceProject,
            ]
        );

        // 🕒 Konversi timestamp
        $timestamp = isset($sensorData['timestamp'])
            ? Carbon::parse($sensorData['timestamp'])->toDateTimeString()
            : now()->toDateTimeString();

        // 🟢 Update status terakhir ke tabel devices
        $device->update([
            'battery' => $sensorData['voltage_baterai'] ?? null,
            'last_seen' => $timestamp,
        ]);

        // 🟢 Simpan data ke sensor_logs
        SensorLog::create([
            'device_id' => $deviceId,
            'device_name' => $deviceName,
            'device_project' => $deviceProject,
            'value1' => $sensorData['value1'] ?? null,
            'value2' => $sensorData['value2'] ?? null,
            'kelembapan' => $sensorData['kelembapan'] ?? null,
            'suhu' => $sensorData['suhu'] ?? null,
            'baterai' => $sensorData['voltage_baterai'] ?? null,
            'recorded_at' => $timestamp,
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
