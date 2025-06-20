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
        'name',
        'location',
        'created_at'
    ];

    public function sensorLogs()
    {
        return $this->hasMany(SensorLog::class);
    }
}
