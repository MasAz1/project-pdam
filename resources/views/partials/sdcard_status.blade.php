@if($sdcard_connected)
    <div class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow animate__animated animate__fadeInDown">
        <i class="fas fa-sd-card mr-2"></i>
        <strong>SD Card Terhubung</strong>
        @if($sdcard_total > 0)
            <span class="ml-2 text-sm">({{ $sdcard_used }}MB / {{ $sdcard_total }}MB)</span>
        @endif
    </div>
@else
    <div class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded shadow animate__animated animate__shakeX">
        <i class="fas fa-sd-card mr-2"></i>
        <strong>SD Card Tidak Terhubung</strong>
    </div>
@endif
