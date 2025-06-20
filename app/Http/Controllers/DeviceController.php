<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DeviceController extends Controller
{
    // Dashboard utama
    public function dashboard()
    {
        $devices = Device::orderBy('created_at', 'asc')->get();
        return view('dashboard', compact('devices'));
    }

    // Hapus device
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('dashboard')->with('success', 'Device berhasil dihapus.');
    }

    // Daftar device
    public function index()
    {
        $devices = Device::all();
        return view('devices.devices', compact('devices'));
    }

    // Form tambah device
    public function create()
    {
        return view('devices.create');
    }

    // Simpan device baru
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:devices,id|max:255',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Device::create([
            'id' => $request->id,
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('dashboard')->with('success', 'Device berhasil ditambahkan.');
    }

    // Tampilkan detail + grafik
    public function show(Device $device, Request $request)
    {
        $query = $device->sensorLogs()->latest();

        if ($request->filled('start')) {
            $query->whereDate('recorded_at', '>=', $request->input('start'));
        }

        if ($request->filled('end')) {
            $query->whereDate('recorded_at', '<=', $request->input('end'));
        }

        $logs = $query->limit(50)->get()->reverse();

        $sensorNames = $device->sensorLogs()
            ->whereNotNull('sensor_name')
            ->distinct()
            ->pluck('sensor_name');

        $latestLog = $device->sensorLogs()->latest()->first();

        return view('devices.show', [
            'device' => $device,
            'sensorNames' => $sensorNames,
            'chartData' => [
                'timestamps' => $logs->pluck('recorded_at')->map(fn($d) => Carbon::parse($d)->format('H:i')),
                'debit'      => $logs->pluck('debit'),
                'kekeruhan'  => $logs->pluck('kekeruhan'),
                'ph'         => $logs->pluck('ph'),
                'suhu'       => $logs->pluck('suhu'),
                'baterai'    => $logs->pluck('baterai'),
            ],

            // Info tambahan
            'firmware_version' => $device->firmware_version ?? 'Tidak tersedia',
            'firmware_last_update' => $device->firmware_updated_at
                ? Carbon::parse($device->firmware_updated_at)->diffForHumans()
                : 'Tidak tersedia',
            'latest_firmware_version' => '1.0.5',
            'firmware_update_available' => isset($device->firmware_version)
                && version_compare($device->firmware_version, '1.0.5', '<'),

            'debit_air'   => $latestLog->debit ?? 0,
            'tekanan'     => $latestLog->tekanan ?? 0,
            'kelembaban'  => $latestLog->kelembaban ?? 0,
            'suhu'        => $latestLog->suhu ?? 0,
            'baterai'     => $latestLog->baterai ?? 0,

            'sdcard_connected' => $device->sdcard_status === 'connected',
        ]);
    }

    // Download PDF log
    public function downloadPdf(Device $device)
    {
        $sensorLogs = SensorLog::where('device_id', $device->id)
            ->orderBy('recorded_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('devices.pdf', [
            'device' => $device,
            'sensorLogs' => $sensorLogs
        ]);

        return $pdf->download('sensor-' . $device->name . '.pdf');
    }

    // ✅ Tambahan: Endpoint untuk AJAX memuat status SD Card real-time
    public function sdcardStatus($id)
    {
        $device = Device::findOrFail($id);

        $sdcard_connected = $device->sdcard_status === 'connected';
        $sdcard_used = $device->sdcard_used ?? 0;
        $sdcard_total = $device->sdcard_total ?? 0;

        return view('partials.sdcard_status', compact('sdcard_connected', 'sdcard_used', 'sdcard_total'));
    }
}
