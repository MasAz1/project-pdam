<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeviceF extends Model
{
    protected $fillable = [
        'device_id',
        'name',
        'model',
        'current_firmware_version',
        'target_firmware_version',
        'status',
        'group',
        'last_online_at',
    ];

    protected $casts = [
        'last_online_at' => 'datetime',
    ];

    public function updateHistories(): HasMany
    {
        return $this->hasMany(DeviceUpdateHistory::class);
    }

    public function firmwares(): BelongsToMany
    {
        return $this->belongsToMany(Firmware::class);
    }

    public function latestUpdate()
    {
        return $this->hasOne(DeviceUpdateHistory::class)->latestOfMany();
    }
}