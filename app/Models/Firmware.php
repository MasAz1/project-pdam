<?php
// app/Models/Firmware.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Firmware extends Model
{
    protected $fillable = [
        'version',
        'name',
        'model',
        'release_notes',
        'file_path',
        'file_size',
    ];

    public function updateHistories(): HasMany
    {
        return $this->hasMany(DeviceUpdateHistory::class);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }
    
    public function getFileSizeFormattedAttribute()
    {
        $size = $this->file_size;
        if ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' bytes';
        }
    }
}
