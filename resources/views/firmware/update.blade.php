@extends('layouts.app')

@section('content')
		@php
	$bgColorProject = match ($device->project) {
		1 => '#0d3b66',
		2 => '#14532d',
		default => '#112240'
	};
		@endphp
				<div style="background-color: {{ $bgColorProject }}"
					class="w-full min-h-screen bg-[#7657765] p-6 text-white rounded-xl shadow-xl">

					<!-- Header dan Tombol Kembali -->
					<div class="flex justify-between items-center mb-6">
						<a href="{{ route('devices.show', ['id' => $device->id]) }}"
							class="inline-flex items-center text-blue-400 hover:text-blue-200 text-sm font-semibold">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
							</svg>
							Kembali ke Dashboard
						</a>

						<h2 class="text-2xl font-bold text-blue-400">Update Firmware: {{ $device->name }}</h2>
					</div>

					<!-- Alert Success -->
					@if(session('success'))
						<div class="bg-green-600 px-4 py-2 rounded mb-6 shadow text-white">
							{{ session('success') }}
						</div>
					@endif

					<!-- Form Upload Firmware -->
					<form action="{{ route('firmware.upload', $device->id) }}" method="POST" enctype="multipart/form-data"
						class="bg-blue-950 rounded-lg p-6 shadow space-y-5 mb-10 border border-blue-700">
						@csrf

						<div>
							<label class="block font-semibold mb-1 text-blue-100">Versi Firmware</label>
							<input type="text" name="version" placeholder="v1.0.0"
								class="w-full px-4 py-2 rounded bg-blue-900 border border-blue-400 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-300"
								required />
						</div>

						<div>
							<label class="block font-semibold mb-1 text-blue-100">File Firmware (.bin)</label>
							<input type="file" name="file" accept=".bin"
								class="w-full px-4 py-2 rounded bg-blue-900 border border-blue-400 text-white file:bg-blue-600 file:text-white file:border-none file:px-4 file:py-2 file:rounded cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-300"
								required />
						</div>

						<button type="submit"
							class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold shadow transition-all">
							🚀 Upload Firmware
						</button>
					</form>

					<!-- Daftar Firmware -->
					<h3 class="text-xl font-semibold mb-4 text-blue-300">Daftar Firmware Tersedia</h3>

					<div class="space-y-3">
						@forelse($firmwares as $fw)
							<div class="flex justify-between items-center bg-blue-900 border border-blue-600 rounded-lg px-4 py-3 shadow">
								<div>
									<p><strong class="text-white">Versi:</strong> {{ $fw->version }}</p>
									<p class="text-sm text-blue-200">Dibuat: {{ $fw->created_at->format('d M Y H:i') }}</p>
								</div>
								<a href="{{ Storage::url($fw->file_path) }}" target="_blank"
									class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium shadow">
									Download
								</a>
							</div>
						@empty
							<p class="text-blue-300">Belum ada firmware yang diunggah.</p>
						@endforelse
					</div>
				</div>
@endsection