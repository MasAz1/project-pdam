<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Air</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    
    <link href="<?php echo e(asset('css/devices.css')); ?>" rel="stylesheet">

    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php echo $__env->yieldContent('content'); ?>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <script>
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: <?php echo json_encode(session('success'), 15, 512) ?>,
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: <?php echo json_encode(session('error'), 15, 512) ?>,
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if($errors->any()): ?>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: <?php echo json_encode($errors->first(), 15, 512) ?>,
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>

    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\laravel\projectPdam\resources\views/layouts/app.blade.php ENDPATH**/ ?>