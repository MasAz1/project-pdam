<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceUpdateHistory extends Model
{
    protected $fillable = [
        'device_id',
        'firmware_id',
        'status',
        'log',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function firmware(): BelongsTo
    {
        return $this->belongsTo(Firmware::class);
    }
}
