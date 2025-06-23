@extends('layouts.app')

@section('content')
    <div class="min-h-screen p-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="w-full sm:w-auto">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition">
                    <i class="bi bi-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
            <div>
                <a href="{{ route('devices.create') }}"
                    class="inline-flex items-center bg-blue-300 text-gray-900 text-sm px-4 py-2 rounded hover:bg-blue-400 transition">
                    <i class="bi bi-plus-circle mr-2"></i> Tambah Device
                </a>
            </div>
        </div>

        {{-- SweetAlert Success --}}
        @if(session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        {{-- Card Container --}}
        <div class="bg-white shadow-xl rounded-xl p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-blue-700 mb-4 flex items-center">
                <i class="bi bi-hdd-network-fill mr-2 text-blue-500 text-2xl"></i> 📋 Daftar Device
            </h2>

            @if($devices->isEmpty())
                <div class="text-center py-10 bg-blue-50 text-blue-700 rounded-lg text-sm sm:text-base">
                    <i class="bi bi-info-circle-fill mr-2"></i> Belum ada device yang ditambahkan.
                </div>
            @else
                {{-- Grid Item View --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($devices as $device)
                        <div class="bg-gray-50 p-5 rounded-xl shadow hover:shadow-md transition border border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-sm text-gray-500">ID: {{ $device->id }}</div>
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded">
                                    #{{ Str::slug($device->name) }}
                                </span>
                            </div>
                            <div class="text-lg font-semibold text-gray-800 mb-1">{{ $device->name }}</div>
                            <div class="text-gray-600 text-sm mb-2">
                                <i class="bi bi-geo-alt-fill mr-1 text-blue-500"></i>{{ $device->location }}
                            </div>

                            {{-- Tambahan: Tampilkan error log jika ada --}}
                            @if($device->errorLogs->isNotEmpty())
                                <div class="bg-red-100 text-red-700 text-xs px-3 py-2 rounded-md mt-2">
                                    <strong>Log Error:</strong> {{ $device->errorLogs->last()->message }}
                                    <div class="text-[10px] mt-1 italic">
                                        [{{ $device->errorLogs->last()->logged_at->format('d M Y H:i') }}]
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            @endif
        </div>
    </div>
@endsection