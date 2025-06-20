<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Air</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Vite: Load Tailwind (app.css) dan JavaScript (app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom CSS Devices --}}
    <link href="{{ asset('css/devices.css') }}" rel="stylesheet">

    {{-- Optional: Style tambahan --}}
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen p-6">
        @yield('content')
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SweetAlert Logic --}}
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: @json(session('error')),
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: @json($errors->first()),
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>

    {{-- Optional: Script tambahan dari view --}}
    @yield('scripts')
</body>
</html>
