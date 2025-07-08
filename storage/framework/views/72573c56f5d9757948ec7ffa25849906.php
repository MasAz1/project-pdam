<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Monitoring PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-dark text-white d-flex align-items-center" style="height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center mb-4">Login</h2>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: <?php echo json_encode(session('success'), 15, 512) ?>,
            timer: 1000,
            showConfirmButton: false
        });
    <?php elseif(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: <?php echo json_encode(session('error'), 15, 512) ?>,
            timer: 1000,
            showConfirmButton: false
        });
    <?php elseif($errors->any()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: <?php echo json_encode($errors->first(), 15, 512) ?>,
            timer: 1000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>

</body>
</html>
<?php /**PATH D:\laravel\projectPdam\resources\views/auth/login.blade.php ENDPATH**/ ?>