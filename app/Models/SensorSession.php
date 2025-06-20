<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorSession extends Model
{
    protected $fillable = [
        'device_id',
        'device_name',
        'sub',
        'session_number',
        'value_1',
        'unit_1',
        'value_2',
        'unit_2',
        'timestamp'
    ];
}
