<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $fillable = ['device_id', 'message'];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
