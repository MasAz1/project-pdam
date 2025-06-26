@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full px-6 py-10 text-white">
        <div class="max-w-6xl mx-auto space-y-8">

            <!-- 🔙 Back Button -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 text-sm font-semibold my-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>

            <!-- 🧾 Info Device -->
            <div class="bg-[#112240] p-6 rounded-xl shadow-lg my-4">
                <h1 class="text-2xl font-bold text-blue-400 mb-4">Monitoring Device: {{ $device->name }}</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>ID:</strong> {{ $device->id }}</p>
                    <form action="{{ route('devices.update.location', $device) }}" method="POST"
                        class="md:col-span-2 flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <label for="location" class="block text-sm font-semibold">Lokasi:</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $device->location) }}"
                            class="flex-1 bg-[#1e2a3a] text-white border border-blue-400 rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:border-blue-300"
                            onkeydown="if (event.key === 'Enter') this.form.submit();">
                    </form>
                    <p><strong>Battery:</strong> {{ $device->battery ?? '-' }}%</p>
                    <p>
                        <strong>SD Card:</strong>
                        <span class="px-2 py-1 rounded {{ $sdcard_connected ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $sdcard_connected ? 'Tersambung' : 'Tidak Tersambung' }}
                        </span>
                    </p>
                    <p><strong>Versi Firmware:</strong> {{ $firmware_version }}</p>
                    <p><strong>Update Firmware Terakhir:</strong> {{ $firmware_last_update }}</p>
                    <p><strong>Terakhir Online:</strong>
                        {{ $device->last_seen ? \Carbon\Carbon::parse($device->last_seen)->diffForHumans() : '-' }}</p>
                    <p><strong>Last Debug:</strong> {{ $device->last_debug ?? '-' }}</p>
                    <p><strong>Dibuat:</strong> {{ $device->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Diperbarui:</strong> {{ $device->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- 🔍 Filter -->
            <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-6 my-4">

                <!-- ✅ Filter Tipe Data -->
                <div class="col-span-1 md:col-span-2 xl:col-span-3">
                    <label class="text-sm block mb-1 text-black">Tampilkan Data:</label>
                    <div style="scrollbar-gutter: stable;" class="w-full overflow-x-auto bg-white text-black border border-[#112240] rounded py-2 px-3">
                        <div style="width: max-content;" class="inline-flex gap-2">
                            @php
    $selected = request()->input('types', ['value1']);
    $sensorTypes = array_merge($labelMap, [
        'suhu' => 'Suhu',
        'kelembapan' => 'Kelembapan',
        'baterai' => 'Baterai',
    ]);
                            @endphp
                            @foreach ($sensorTypes as $key => $label)
                                <label class="inline-flex items-center gap-2 bg-[#1e2a3a] text-black rounded cursor-pointer hover:bg-blue-500 transition whitespace-nowrap flex-shrink-0">
                                    <input type="checkbox" name="types[]" value="{{ $key }}"
                                        {{ in_array($key, (array) $selected) ? 'checked' : '' }}
                                        class="form-checkbox text-blue-500 bg-[#1e2a3a]">
                                    <span class="text-sm whitespace-nowrap inline-block">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- ✅ Filter Tanggal Mulai -->
                <div>
                    <label class="text-sm block mb-1 text-black">Filter Waktu Awal:</label>
                    <input type="date" name="start" value="{{ request('start') }}" class="w-full bg-white text-black border border-[#112240] px-3 py-2 rounded">
                </div>

                <!-- ✅ Filter Tanggal Selesai -->
                <div>
                    <label class="text-sm block mb-1 text-black">Filter Waktu Akhir:</label>
                    <input type="date" name="end" value="{{ request('end') }}" class="w-full bg-white text-black border border-[#112240] px-3 py-2 rounded">
                </div>

                <!-- ✅ Tombol Filter -->
                <div class="flex gap-2 w-full h-min">
                    <button type="submit" class="flex-1 bg-blue-500 text-white rounded cursor-pointer">
                        Filter
                    </button>
                    <a href="{{ route('devices.export.pdf', ['device' => $device->id] + request()->only('types', 'start', 'end')) }}"
                        class="flex-1 bg-green-600 hover:bg-green-700 rounded text-white text-center px-4 py-2 flex items-center justify-center">
                        Download (PDF)
                    </a>
                </div>

            </form>            

            <!-- 📊 Grafik Sensor -->
            <div class="bg-[#112240] p-4 rounded-xl shadow-md my-4">
                <h2 class="text-xl font-bold mb-4 text-blue-300">Grafik Sensor</h2>
                <canvas id="sensorChart" class="h-max"></canvas>
            </div>

            <!-- 📋 Data Terbaru -->
            <div class="bg-[#112240] p-4 rounded-xl text-sm my-4">
                <h3 class="font-semibold text-blue-400 mb-2">Data Sensor Terbaru:</h3>
                <ul class="grid grid-cols-2 md:grid-cols-3 gap-y-2">
                    <li><strong>Debit Air:</strong> {{ $debit_air }} m³/s</li>
                    <li><strong>Tekanan:</strong> {{ $tekanan }} bar</li>
                    <li><strong>Suhu:</strong> {{ $suhu }} °C</li>
                    <li><strong>Kelembapan:</strong> {{ $kelembapan }} %</li>
                    <li><strong>Baterai:</strong> {{ $baterai }} V</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('sensorChart').getContext('2d');
        let sensorChart = new Chart(ctx, {
            type: 'line',
            data: { labels: [], datasets: [] },
            options: {
                responsive: true,
                animation: false,
                scales: {
                    x: { ticks: { color: '#fff' } },
                    y: { ticks: { color: '#fff' } }
                },
                plugins: {
                    legend: { labels: { color: '#fff' } }
                }
            }
        });

        function getQueryParams() {
            const params = new URLSearchParams(window.location.search);
            return {
                types: params.getAll('types[]').length ? params.getAll('types[]') : ['value1'],
                start: params.get('start'),
                end: params.get('end')
            };
        }

        function updateChart() {
            const { types, start, end } = getQueryParams();
            const urlParams = new URLSearchParams();
            types.forEach(t => urlParams.append('types[]', t));
            if (start) urlParams.set('start', start);
            if (end) urlParams.set('end', end);

            fetch(`{{ url('/devices/' . $device->id . '/chart-data') }}?${urlParams.toString()}`)
                .then(res => res.json())
                .then(data => {
                    sensorChart.data.labels = data.timestamps;
                    sensorChart.data.datasets = [];

                    const colorMap = {
                        value1: 'rgba(59,130,246,1)',
                        value2: 'rgba(96,165,250,1)',
                        suhu: 'rgba(252,165,165,1)',
                        kelembapan: 'rgba(134,239,172,1)',
                        baterai: 'rgba(253,224,71,1)',
                    };

                    const labelMap = @json($labelMap); // ← Tambahkan ini

                    Object.entries(data.datasets).forEach(([key, values]) => {
                        sensorChart.data.datasets.push({
                            label: labelMap[key] || key, // ← Label dinamis
                            data: values,
                            fill: false,
                            borderColor: colorMap[key] || 'white',
                            backgroundColor: colorMap[key] || 'white',
                            tension: 0.3,
                            pointRadius: 2
                        });
                    });

                    sensorChart.update();
                });
        }

        updateChart();
        setInterval(updateChart, 5000);
    </script>
@endsection
