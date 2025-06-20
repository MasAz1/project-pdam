<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Monitoring PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-dark text-white d-flex align-items-center" style="height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center mb-4">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            timer: 1000,
            showConfirmButton: false
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: @json(session('error')),
            timer: 1000,
            showConfirmButton: false
        });
    @elseif($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: @json($errors->first()),
            timer: 1000,
            showConfirmButton: false
        });
    @endif
</script>

</body>
</html>
