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
        'value1',
        'value2',
        'kelembapan',
        'suhu',
        'recorded_at'
    ];

    // public $timestamps = false;

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
