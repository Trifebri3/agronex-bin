<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoilData extends Model
{
    protected $table = 'soil_data';

    protected $fillable = [
        'kelembapan',
        'suhu',
        'ec',
        'ph',
        'nitrogen',
        'fosfor',
        'kalium',
    ];
}