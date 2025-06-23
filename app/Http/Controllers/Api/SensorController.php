<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorLog;
use App\Models\Device;

class SensorController extends Controller
{
    // Simpan data dari IoT
    public function store(Request $request)
    {
        $request->validate([
            'device_id'    => 'required|exists:devices,id',
            'debitair'     => 'required|numeric',
            'tekanan'      => 'nullable|numeric',
            'kelembaban'   => 'nullable|numeric',  
            'suhu'         => 'nullable|numeric',
            'baterai'      => 'nullable|numeric',
            'sensor_name'  => 'nullable|string',
        ]);

        $data = SensorLog::create([
            'device_id'   => $request->device_id,
            'debitair'    => $request->debitair,
            'tekanan'     => $request->tekanan,
            'kelembaban'  => $request->kelembaban, 
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
