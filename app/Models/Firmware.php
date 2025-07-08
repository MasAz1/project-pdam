<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firmware extends Model
{
    protected $fillable = ['version', 'file_path'];
    protected $table = 'firmwares';

}
