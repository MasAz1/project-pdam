<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        Device::create([
            'name' => 'Device PDAM A',
            'location' => 'Lokasi 1',
            'firmware_version' => '1.0.3',
            'sdcard_status' => 'connected',
            'sdcard_used' => 512,
            'sdcard_total' => 1024,
        ]);

        Device::create([
            'name' => 'Device PDAM B',
            'location' => 'Lokasi 2',
            'firmware_version' => '1.0.4',
            'sdcard_status' => 'disconnected',
            'sdcard_used' => null,
            'sdcard_total' => null,
        ]);
    }
}
