@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full bg-[#0a192f] text-white py-8 px-4">
        <div class="max-w-lg mx-auto">

            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold text-blue-300 hover:text-white transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Judul -->
            <div class="mb-6 text-center md:text-left">
                <h1 class="text-2xl font-bold text-blue-300">Tambah Device</h1>
            </div>

            <!-- Form -->
            <form id="device-form" action="{{ route('devices.store') }}" method="POST"
                class="bg-white text-black p-6 rounded-lg shadow-md border border-gray-300 space-y-4">
                @csrf

                <div>
                    <label for="id" class="block font-semibold mb-1">ID Device</label>
                    <input type="number" name="id" id="id" value="{{ old('id') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="id" class="block font-semibold mb-1">Project</label>
                    <input type="number" name="project" id="project" value="{{ old('project') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="name" class="block font-semibold mb-1">Nama Device</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="location" class="block font-semibold mb-1">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex justify-end pt-2">
                    <button id="submit-btn" type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg border border-green-800">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 1000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal menyimpan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    <script>
        document.getElementById('device-form').addEventListener('submit', function (e) {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerText = 'Menyimpan...';
        });
    </script>
@endsection