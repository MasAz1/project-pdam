@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto">
    <a href="{{ route('dashboard') }}" class="text-blue-600 underline">&larr; Kembali ke Dashboard</a>

    <h1 class="text-2xl font-bold mt-6 mb-4">Tambah Device</h1>

    <form id="device-form" action="{{ route('devices.store') }}" method="POST" class="bg-white p-6 shadow rounded border border-gray-300">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">ID Device</label>
            <input type="number" name="id" id="id" value="{{ old('id') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Device</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label for="location" class="block font-semibold mb-1">Lokasi</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="flex justify-end">
            <button id="submit-btn" type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded border border-green-800">
                Simpan
            </button>
        </div>
    </form>
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

{{-- Script untuk mencegah spam dan clear input --}}
<script>
    document.getElementById('device-form').addEventListener('submit', function (e) {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerText = 'Menyimpan...';

        // Optional: Clear input setelah submit
        // document.getElementById('name').value = '';
        // document.getElementById('location').value = '';
    });
</script>
@endsection
