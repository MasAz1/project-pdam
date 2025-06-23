<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SensorLog;
use App\Models\DeviceErrorLog;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'location',
        'created_at'
    ];

    // ✅ Relasi ke sensor logs
    public function sensorLogs()
    {
        return $this->hasMany(SensorLog::class, 'device_id');
    }

    // ✅ Relasi ke error logs
    public function errorLogs()
    {
        return $this->hasMany(ErrorLog::class, 'device_id');
    }
}
