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
            'project' => 'required|integer',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Device::create([
            'id' => $request->id,
            'project' => $request->project,
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('dashboard')->with('success', 'Device berhasil ditambahkan.');
    }

    private function getSensorLabels($project)
    {
        return match ((int) $project) {
            1 => ['value1' => 'Debit Air', 'value2' => 'Tekanan Air', 'volume' => 'Volume Air'],
            2 => ['value1' => 'Curah Hujan', 'value2' => 'Ketinggian Air'],
            default => ['value1' => 'Value 1', 'value2' => 'Value 2'],
        };
    }

    // Tampilkan detail + grafik
    public function show(Device $device, Request $request)
    {
        $query = $device->sensorLogs()->latest();

        // 🔍 Filter berdasarkan tanggal (jika ada)
        if ($request->filled('start')) {
            $query->whereDate('recorded_at', '>=', $request->input('start'));
        }

        if ($request->filled('end')) {
            $query->whereDate('recorded_at', '<=', $request->input('end'));
        }

        $logs = $query->get();

        $latestLog = $device->sensorLogs()->latest()->first();

        // 🏷 Ambil jenis data yang ingin ditampilkan di grafik (default: value1)
        $type = $request->input('type', 'value1');
        $chartValues = $logs->pluck($type);

        // 🏷 Label sensor sesuai project
        $labelMap = $this->getSensorLabels($device->project);

        $chartLabel = $labelMap[$type] ?? ucfirst($type);

        $data = [
            'device' => $device,

            'chartData' => [
                'timestamps'   => $logs->pluck('recorded_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d-m-Y H:i')),
                'value1'       => $logs->pluck('value1'),
                'value2'       => $logs->pluck('value2'),
                'kelembapan'   => $logs->pluck('kelembapan'),
                'suhu'         => $logs->pluck('suhu'),
            ],

            // ℹ️ Info firmware
            'firmware_version' => $device->firmware ?? 'Tidak tersedia',
            'firmware_last_update' => $device->firmware_updated_at
                ? $device->firmware_updated_at
                : 'Tidak tersedia',
            'latest_firmware_version' => '1.0.5',
            'firmware_update_available' => isset($device->firmware)
                && version_compare($device->firmware, '1.0.5', '<'),

            // 📈 Data sensor terbaru
            'value1'   => $latestLog->value1 ?? 0,
            'value2'     => $latestLog->value2 ?? 0,
            'suhu'        => $latestLog->suhu ?? 0,
            'kelembapan'  => $latestLog->kelembapan ?? 0,

            // ⚙️ Status SD Card
            'sdcard_connected' => $device->sdcard == '1' || $device->sdcard === 1,

            // Grafik
            'chartType' => $type,
            'chartLabel' => $chartLabel,
            'chartValues' => $chartValues,

            // Label dinamis
            'labelMap' => $labelMap,
        ];

        if ($device->project == 1) {
            $data['chartData']['volume'] = $logs->pluck('volume');
            $data['volume'] = $latestLog->volume ?? 0;
        }

        return view('devices.show', $data);
    }

    // Download PDF log
    public function exportPdf(Device $device, Request $request)
    {
        $types = $request->input('types', ['value1']); // default 1 data
        if (!is_array($types)) {
            $types = explode(',', $types);
        }

        $start = $request->input('start');
        $end = $request->input('end');

        $query = $device->sensorLogs()->orderBy('recorded_at');

        if ($start) {
            $query->where('recorded_at', '>=', Carbon::parse($start)->startOfDay());
        }

        if ($end) {
            $query->where('recorded_at', '<=', Carbon::parse($end)->endOfDay());
        }

        $logs = $query->get();

        return Pdf::loadView('devices.export_pdf', [
            'device' => $device,
            'logs' => $logs,
            'types' => $types,
            'start' => $start,
            'end' => $end,
            'sensorLabels' => $this->getSensorLabels($device->project),
        ])->download("grafik-device-{$device->id}.pdf");
    }
    public function chartData(Device $device, Request $request)
    {
        $types = $request->input('types', ['value1']);
        if (!is_array($types)) {
            $types = explode(',', $types);
        }

        $query = $device->sensorLogs()->orderBy('recorded_at');

        $start = $request->input('start');
        $end = $request->input('end');

        if ($start) {
            $query->where('recorded_at', '>=', Carbon::parse($start));
        }

        if ($end) {
            $query->where('recorded_at', '<=', Carbon::parse($end));
        }


        $logs = $query->get();

        $response = [
            'timestamps' => $logs->pluck('recorded_at')->map(fn($d) => Carbon::parse($d)->format('d-m-Y H:i')),
            'datasets' => [],
        ];

        foreach ($types as $type) {
            $response['datasets'][$type] = $logs->pluck($type);
        }

        $latestLog = $device->sensorLogs()->latest('recorded_at')->first();

        $latest = [
            'value1' => $latestLog->value1 ?? 0,
            'value2' => $latestLog->value2 ?? 0,
            'suhu' => $latestLog->suhu ?? 0,
            'kelembapan' => $latestLog->kelembapan ?? 0,
        ];

        if ($device->project == 1) {
            $latest['volume'] = $latestLog->volume ?? 0;
        }

        $response['latest'] = $latest;

        $response['device'] = [
            'firmware' => $device->firmware ?? 'Tidak tersedia',
            'firmware_updated_at' => $device->firmware_updated_at
                ? Carbon::parse($device->firmware_updated_at)->diffForHumans()
                : 'Tidak tersedia',
            'battery' => $device->battery ?? 0,
            'sdcard' => $device->sdcard == '1' || $device->sdcard === 1,
            'last_seen' => $device->last_seen
                ? $device->last_seen
                : 'Tidak tersedia',
        ];

        return response()->json($response);
    }

    public function updateLocation(Request $request, Device $device)
    {
        $request->validate([
            'location' => 'nullable|string|max:255',
        ]);

        $device->update(['location' => $request->location]);

        return back()->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function errorLogs(Device $device)
    {
        $logs = $device->errorLogs()->latest()->paginate(10); // Sesuaikan relasi dengan model kamu
        return view('devices.error_logs', compact('device', 'logs'));
    }


    public function sdcardStatus($id)
    {
        $device = Device::findOrFail($id);

        $sdcard_connected = $device->sdcard_status === 'connected';
        $sdcard_used = $device->sdcard_used ?? 0;
        $sdcard_total = $device->sdcard_total ?? 0;

        return view('partials.sdcard_status', compact('sdcard_connected', 'sdcard_used', 'sdcard_total'));
    }

    public function getVoltase($id)
    {
        $voltase = SensorLog::where('device_id', $id)
            ->latest('recorded_at')
            ->value('voltase');

        return response()->json(['voltase' => $voltase ?? 0]);
    }
}
