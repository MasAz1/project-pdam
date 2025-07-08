<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SensorLog;
use App\Models\ErrorLog;
use App\Models\FirmwareLog; // <-- Tambahkan ini

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'project',
        'name',
        'location',
        'battery',
        'sdcard',
        'firmware',
        'firmware_updated_at',
        'last_seen',
        'last_debug',
        'last_debug_info',
    ];

    public function sensorLogs()
    {
        return $this->hasMany(SensorLog::class);
    }

    public function errorLogs()
    {
        return $this->hasMany(ErrorLog::class, 'device_id');
    }
}
