<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorLog;
use App\Models\Device;
// Pastikan SensorSession hanya jika kamu punya model-nya, kalau tidak ada, hapus baris ini
// use App\Models\SensorSession;

class SensorController extends Controller
{
    // Simpan data dari IoT
    public function store(Request $request)
    {
        $request->validate([
            'device_id'    => 'required|exists:devices,id',
            'debit'        => 'required|numeric',
            'tekanan'      => 'nullable|numeric',
            'kekeruhan'    => 'nullable|numeric',
            'ph'           => 'nullable|numeric',
            'suhu'         => 'nullable|numeric',
            'baterai'      => 'nullable|numeric',
            'sensor_name'  => 'nullable|string',
        ]);

        $data = SensorLog::create([
            'device_id'   => $request->device_id,
            'debit'       => $request->debit,
            'tekanan'     => $request->tekanan,
            'kekeruhan'   => $request->kekeruhan,
            'ph'          => $request->ph,
            'suhu'        => $request->suhu,
            'baterai'     => $request->baterai,
            'sensor_name' => $request->sensor_name,
            'recorded_at' => now(),
        ]);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data'    => $data
        ], 201);
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
