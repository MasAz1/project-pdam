<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorLog;
use App\Models\SensorSession;

class SensorController extends Controller
{
	// Simpan data dari IoT
	public function store(Request $request)
	{
		$device = $request->input('device');
		$sub = $device['sub'];
		$sessions = $request->input('data');
		foreach ($sessions as $session => $data) {
			$session_number = (int)$session;
			$timestamp = $data['timestamp'] ?? now();
		
			if ($sub == 1) {
				// sub == 1: debit_air + tekanan_air
				SensorSession::create([
					'device_id' => $device['id'],
					'device_name' => $device['name'],
					'sub' => $sub,
					'session_number' => $session_number,
					'value_1' => $data['debit_air']['value'],
					'unit_1' => $data['debit_air']['unit'],
					'value_2' => $data['tekanan_air']['value'],
					'unit_2' => $data['tekanan_air']['unit'],
					'timestamp' => $timestamp,
				]);
			} else {
				// sub ≠ 1: tinggi_air + hujan
				SensorSession::create([
					'device_id' => $device['id'],
					'device_name' => $device['name'],
					'sub' => $sub,
					'session_number' => $session_number,
					'value_1' => $data['tinggi_air']['value'],
					'unit_1' => $data['tinggi_air']['unit'],
					'value_2' => $data['hujan']['value'],
					'unit_2' => $data['hujan']['unit'],
					'timestamp' => $timestamp,
				]);
			}
		}
		
		return response()->json(['message' => 'Data berhasil disimpan'], 201);
	}

	// Ambil semua data terbaru (limit 100)
	public function index()
	{
		$logs = SensorLog::latest()->limit(100)->get();
		return response()->json($logs);
	}

	// Ambil data terbaru
	public function latest()
	{
		$latest = SensorLog::latest()->first();
		return response()->json($latest);
	}
}
