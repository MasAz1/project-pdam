<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class SensorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'debit',
        'tekanan',
        'kekeruhan',
        'ph',
        'suhu',
        'baterai',
        'sensor_name',
        'recorded_at',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
