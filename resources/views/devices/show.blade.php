@extends('layouts.app')

@section('content')
<div class="bg-[#0a192f] text-white min-h-screen p-4 rounded-lg">

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-300 hover:text-white transition block">&larr; Kembali ke Dashboard</a>
    </div>

    <!-- Filter dan Tombol PDF -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div class="w-full md:w-auto">
            <form method="GET" class="space-y-3 md:space-y-0 md:flex md:items-center gap-2 flex-wrap">
                <label class="block my-3 text-sm w-full md:w-auto text-white">Filter Waktu:</label>
                <input type="date" name="start" value="{{ request('start') }}" class="bg-white my-3 text-black p-1 rounded w-full md:w-auto">
                <input type="date" name="end" value="{{ request('end') }}" class="bg-white my-3 text-black p-1 rounded w-full md:w-auto">
                <button type="submit" class="bg-blue-500 my-3 hover:bg-blue-600 text-white px-2 py-1 rounded w-full md:w-auto">Terapkan</button>

                @if (request('start') || request('end'))
                    <a href="{{ route('devices.show', $device->id) }}" class="text-sm text-blue-300 hover:text-white block md:inline">Reset Waktu</a>
                @endif
            </form>
        </div>

        <a href="{{ route('devices.downloadPdf', $device->id) }}" target="_blank"
           class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white font-semibold text-center w-full md:w-auto">
            Download PDF
        </a>
    </div>

    <!-- Info Device -->
    <div class="text-center my-6 space-y-2">
        <h1 class="text-3xl font-bold text-blue-400 my-4 mt-8">Monitoring Device {{ $device->name }}</h1>
        <p><strong>Lokasi:</strong> <span class="text-white">{{ $device->location }}</span></p>
        <p><strong>Firmware Version:</strong> <span style="color: #ffffff;">{{ $device->firmware_version ?? 'N/A' }}</span></p>

        @if (!empty($firmware_update_available))
            <span class="inline-block bg-yellow-500 text-black px-3 py-1 rounded font-semibold animate-pulse">
                Update Firmware Tersedia (v{{ $latest_firmware_version ?? '' }})
            </span>
        @else
            <span class="inline-block bg-green-600 px-3 py-1 rounded font-semibold">Firmware Terbaru</span>
        @endif

        <p class="text-sm text-gray-300">
            <small>Update terakhir: {{ $firmware_last_update ?? 'Tidak diketahui' }}</small>
        </p>

        <!-- Status Sensor -->
        <div class="text-center mb-4">
            @if(($chartData['debit']->last() ?? 0) == 0 && ($chartData['suhu']->last() ?? 0) == 0 && ($chartData['baterai']->last() ?? 0) == 0)
                <h5><span class="inline-block bg-red-600 px-4 py-2 rounded text-white font-semibold">Sensor Offline</span></h5>
            @else
                <h5><span class="inline-block bg-green-600 px-4 py-2 rounded text-white font-semibold">Sensor Aktif</span></h5>
            @endif
        </div>

        <!-- Status SD Card -->
        <div id="sdcard-status" class="text-center my-4">
            <!-- Akan dimuat otomatis via AJAX -->
        </div>
        <script>
            function loadSDCardStatus() {
                fetch("{{ route('device.sdcard.status', $device->id) }}")
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('sdcard-status').innerHTML = html;
                    })
                    .catch(error => console.error("Gagal memuat status SD Card:", error));
            }
            loadSDCardStatus();
            setInterval(loadSDCardStatus, 5000);
        </script>
    </div>

    <!-- Grafik Sensor -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @if (!empty($chartData['debit']))
            <x-chart-box title="Debit Air" :chartId="'debitChart'" />
        @endif
        @if (!empty($chartData['kekeruhan']))
            <x-chart-box title="Kekeruhan" :chartId="'kekeruhanChart'" />
        @endif
        @if (!empty($chartData['ph']))
            <x-chart-box title="pH" :chartId="'phChart'" />
        @endif
        @if (!empty($chartData['suhu']))
            <x-chart-box title="Suhu" :chartId="'suhuChart'" />
        @endif
        @if (!empty($chartData['baterai']))
            <x-chart-box title="Baterai" :chartId="'bateraiChart'" />
        @endif
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartOptions = {
        responsive: true,
        plugins: {
            legend: { labels: { color: 'white' } },
        },
        scales: {
            x: { ticks: { color: 'white' }, grid: { color: '#1a263a' } },
            y: { ticks: { color: 'white' }, grid: { color: '#1a263a' } },
        }
    };

    const chartData = {!! json_encode($chartData) !!};

    const createChart = (id, label, data, color) => {
        new Chart(document.getElementById(id), {
            type: 'line',
            data: {
                labels: chartData.timestamps,
                datasets: [{
                    label,
                    data,
                    borderColor: color,
                    backgroundColor: 'transparent',
                    tension: 0.4
                }]
            },
            options: chartOptions
        });
    };

    @if (!empty($chartData['debit']))
        createChart('debitChart', 'Debit Air', chartData.debit, '#00ffff');
    @endif
    @if (!empty($chartData['kekeruhan']))
        createChart('kekeruhanChart', 'Kekeruhan', chartData.kekeruhan, '#ffcc00');
    @endif
    @if (!empty($chartData['ph']))
        createChart('phChart', 'pH', chartData.ph, '#ff6699');
    @endif
    @if (!empty($chartData['suhu']))
        createChart('suhuChart', 'Suhu', chartData.suhu, '#66ccff');
    @endif
    @if (!empty($chartData['baterai']))
        createChart('bateraiChart', 'Baterai', chartData.baterai, '#00ff00');
    @endif
</script>
@endsection
