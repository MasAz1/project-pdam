

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen p-6min-h-screen text-white py-8 px-4">
        <div class="max-w-6xl mx-auto">

            
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <h1 class="text-3xl font-bold text-blue-600 text-center md:text-left w-full md:w-auto">
                    Monitoring Air
                </h1>
                <div class="flex flex-col md:flex-row items-center gap-3">
                    

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 shadow-sm">
                    <strong>Berhasil!</strong> <?php echo e(session('success')); ?>

                </div>
                <script>
                    setTimeout(() => {
                        document.querySelector('.bg-green-100').remove();
                    }, 5000);
                </script>
            <?php endif; ?>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="relative">
                        <?php
                            $bgColorProject = match ($device->project) {
                                1 => '#0d3b66',
                                2 => '#14532d',
                                default => '#112240'
                            };
                        ?>
                        <a href="<?php echo e(route('devices.show', $device->id)); ?>" style="background-color: <?php echo e($bgColorProject); ?>"
                           class="block shadow-md rounded-xl p-5 border border-blue-600 hover:shadow-xl transition duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-sm text-gray-100">ID: <?php echo e($device->id); ?></div>
                            </div>
                            <div class="text-lg font-semibold text-gray-200 mb-1 text-center"><?php echo e($device->name); ?></div>
                            <div class="text-gray-400 text-sm mb-2 text-center">
                                <i class="bi bi-geo-alt-fill mr-2 text-blue-500"></i><?php echo e($device->location); ?>

                            </div>
                        </a>
                        <form action="<?php echo e(route('devices.destroy', $device->id)); ?>" method="POST"
                              class="absolute top-2 right-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus device ini?')"
                                    class="bg-white rounded p-1 cursor-pointer text-red-500 hover:bg-red-700 hover:text-white text-sm transition"
                                    title="Hapus Device">
                                <i class="bi bi-trash3-fill"></i>Hapus
                            </button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-blue-200 text-center py-12 text-lg">
                        Belum ada device ditambahkan.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\projectPdam\resources\views/dashboard.blade.php ENDPATH**/ ?>