<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $table = 'weather_data';

    protected $fillable = [
        'suhu',
        'kelembapan',
        'tekanan',
        'cahaya',
        'kecepatan_angin',
        'curah_hujan',
        'dew_point',
        'et0',
    ];
}