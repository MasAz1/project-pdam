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

            <div class="flex flex-col-reverse md:flex-row gap-2 md:gap-4">
                <a href="{{ route('devices.errorLogs', $device->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded text-black font-semibold text-center w-full md:w-auto">
                    Lihat Log Error
                </a>

                <a href="{{ route('devices.downloadPdf', $device->id) }}" target="_blank"
                   class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white font-semibold text-center w-full md:w-auto">
                    Download PDF
                </a>
            </div>

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
            <!-- Status Voltase -->
            <div id="voltase-box" class="text-center my-4">
                <h5>
                    <span id="voltase-status" class="inline-block px-4 py-2 rounded text-white font-semibold">
                        <span id="voltase-text">Voltase: </span><span id="voltase-value">Memuat...</span> v
                    </span>
                </h5>
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
            @if (!empty($chartData['tekanan']))
                <x-chart-box title="Tekanan Air" :chartId="'tekananChart'" />
            @endif
            @if (!empty($chartData['suhu']))
                <x-chart-box title="Suhu" :chartId="'suhuChart'" />
            @endif
            @if (!empty($chartData['baterai']))
                <x-chart-box title="Baterai" :chartId="'bateraiChart'" />
            @endif
            @if (!empty($chartData['kelembaban']))
                <x-chart-box title="Kelembaban" :chartId="'kelembabanChart'" />
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
            createChart('debitChart', 'Debit Air', chartData.debitair, '#00ffff');
        @endif
        @if (!empty($chartData['tekanan']))
            createChart('tekananChart', 'Tekanan Air', chartData.tekanan, '#ffcc00');
        @endif
        @if (!empty($chartData['suhu']))
            createChart('suhuChart', 'Suhu', chartData.suhu, '#66ccff');
        @endif
        @if (!empty($chartData['baterai']))
            createChart('bateraiChart', 'Baterai', chartData.baterai, '#00ff00');
        @endif
        @if (!empty($chartData['kelembaban']))
            new Chart(document.getElementById('kelembabanChart'), {
                type: 'line',
                data: {
                    labels: chartData.timestamps,
                    datasets: [{
                        label: 'Kelembaban',
                        data: chartData.kelembaban,
                        borderColor: '#ff66cc',
                        backgroundColor: 'transparent',
                        tension: 0.4
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            ticks: {
                                ...chartOptions.scales.y.ticks,
                                callback: function (value) {
                                    return value + '%';
                                },
                                max: 100 // batas atas 100%
                            }
                        }
                    }
                }
            });
        @endif
    </script>
    <script>
        function loadVoltase() {
            fetch("{{ route('device.voltase', $device->id) }}")
                .then(res => res.json())
                .then(data => {
                    const volt = parseFloat(data.voltase ?? 0);
                    const valueSpan = document.getElementById('voltase-value');
                    const statusSpan = document.getElementById('voltase-status');
                    const textSpan = document.getElementById('voltase-text');

                    valueSpan.innerText = volt.toFixed(2);

                    if (volt <= 3.0) {
                        statusSpan.className = "inline-block bg-red-100 px-4 py-2 rounded font-semibold";
                        valueSpan.className = "text-red-600 font-bold";
                        textSpan.innerText = "Voltase Lemah: ";
                        textSpan.className = "text-red-600 font-bold";
                    } else {
                        statusSpan.className = "inline-block bg-green-100 px-4 py-2 rounded font-semibold";
                        valueSpan.className = "text-green-600 font-bold";
                        textSpan.innerText = "Voltase Normal: ";
                        textSpan.className = "text-green-600 font-bold";
                    }
                })
                .catch(err => {
                    const valueSpan = document.getElementById('voltase-value');
                    const statusSpan = document.getElementById('voltase-status');
                    const textSpan = document.getElementById('voltase-text');

                    valueSpan.innerText = 'Error';
                    valueSpan.className = "text-gray-400 font-bold";
                    textSpan.innerText = "Voltase Tidak Tersedia: ";
                    textSpan.className = "text-gray-400 font-bold";
                    statusSpan.className = "inline-block bg-gray-800 px-4 py-2 rounded font-semibold";

                    console.error("Gagal memuat voltase:", err);
                });
        }

        loadVoltase();
        setInterval(loadVoltase, 5000);
    </script>
@endsection
