@extends('layouts.app')

@section('content')
	<div class="min-h-screen w-full px-6 py-10 text-white">
		<div class="max-w-6xl mx-auto">

			<!-- Tombol Kembali -->
			<div class="mb-10">
				<a href="{{ route('devices.show', $device->id) }}"
					class="inline-flex items-center text-base font-semibold text-blue-300 hover:text-white transition">
					<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
					</svg>
					Kembali ke Device
				</a>
			</div>

			<!-- Header -->
			<div class="mb-6">
				<h1 class="text-3xl font-bold text-yellow-400 leading-snug">
					Log Error ESP8266
				</h1>
				<p class="text-sm text-gray-400 mt-1">
					Riwayat kesalahan yang tercatat dari perangkat <span
						class="text-white font-semibold">{{ $device->name }}</span>.
				</p>
			</div>

			<!-- Konten -->
			@if ($logs->isEmpty())
				<div class="bg-[#1f2937] border border-gray-700 rounded-lg p-8 text-center text-gray-400 shadow-md">
					Tidak ada log error yang tercatat.
				</div>
			@else
				<div class="overflow-hidden rounded-xl bg-[#112240] shadow-lg ring-1 ring-gray-700/40">
					<table class="min-w-full divide-y divide-gray-700">
						<thead class="bg-[#1e2a3a] text-gray-300 uppercase text-xs font-semibold tracking-wider">
							<tr>
								<th class="px-6 py-4 text-left">Waktu</th>
								<th class="px-6 py-4 text-left">Pesan Error</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-800 text-sm text-gray-100">
							@foreach ($logs as $log)
								<tr class="hover:bg-[#1b2c40] transition duration-150">
									<td class="px-6 py-4 whitespace-nowrap font-mono text-blue-200">
										{{ $log->created_at->format('Y-m-d H:i:s') }}
									</td>
									<td class="px-6 py-4">
										{{ $log->message }}
									</td>
								</tr>
							@endforeach

							@if ($logs->hasPages())
								<tr>
									<td colspan="2" class="px-6 py-6 text-center bg-[#101c2b] text-gray-400">
										{{ $logs->links('vendor.pagination.tailwind') }}
									</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			@endif

		</div>
	</div>
@endsection