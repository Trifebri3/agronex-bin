<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterData extends Model
{
    protected $table = 'water_data';

    protected $fillable = [
        'suhu',
        'ph',
        'tds',
        'turbidity',
    ];
}