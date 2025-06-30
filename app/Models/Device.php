<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SensorLog;

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

    // ✅ Relasi ke error logs
    public function errorLogs()
    {
        return $this->hasMany(ErrorLog::class, 'device_id');
    }
}
