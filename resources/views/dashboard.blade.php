@extends('layouts.app')

@section('content')
    <div class="min-h-screen p-6min-h-screen text-white py-8 px-4">
        <div class="max-w-6xl mx-auto">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <h1 class="text-3xl font-bold text-blue-600 text-center md:text-left w-full md:w-auto">
                    Monitoring Air
                </h1>
                <div class="flex flex-col md:flex-row items-center gap-3">
                    {{-- <a href="{{ route('devices.create') }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        + Tambah Device
                    </a> --}}

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 shadow-sm">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        document.querySelector('.bg-green-100').remove();
                    }, 5000);
                </script>
            @endif

            {{-- Device Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($devices as $device)
                    <div class="relative">
                        @php
                            $bgColorProject = match ($device->project) {
                                1 => '#0d3b66',
                                2 => '#14532d',
                                default => '#112240'
                            };
                        @endphp
                        <a href="{{ route('devices.show', $device->id) }}" style="background-color: {{ $bgColorProject }}"
                           class="block shadow-md rounded-xl p-5 border border-blue-600 hover:shadow-xl transition duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-sm text-gray-100">ID: {{ $device->id }}</div>
                            </div>
                            <div class="text-lg font-semibold text-gray-200 mb-1 text-center">{{ $device->name }}</div>
                            <div class="text-gray-400 text-sm mb-2 text-center">
                                <i class="bi bi-geo-alt-fill mr-2 text-blue-500"></i>{{ $device->location }}
                            </div>
                        </a>
                        <form action="{{ route('devices.destroy', $device->id) }}" method="POST"
                              class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus device ini?')"
                                    class="bg-white rounded p-1 cursor-pointer text-red-500 hover:bg-red-700 hover:text-white text-sm transition"
                                    title="Hapus Device">
                                <i class="bi bi-trash3-fill"></i>Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-blue-200 text-center py-12 text-lg">
                        Belum ada device ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
