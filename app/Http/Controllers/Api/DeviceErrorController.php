<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceErrorLog;
use App\Models\Device;

class DeviceErrorController extends Controller
{
    // Menampilkan semua log error (GET /api/error-log)
    public function index()
    {
        return response()->json(Device::with('device')->latest()->get());
    }

    // (Optional) method POST yang sudah kamu buat sebelumnya
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'message' => 'required|string',
            'error_code' => 'nullable|string',
            'logged_at' => 'required|date',
        ]);

        Device::create($request->only('device_id', 'message', 'error_code', 'logged_at'));

        return response()->json(['status' => 'Log error disimpan']);
    }
}
