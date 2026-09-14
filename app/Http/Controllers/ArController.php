<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoilData;
use App\Models\WeatherData;
use App\Models\WaterData;

class ArController extends Controller
{
    public function index()
    {
        $latestSoil = SoilData::latest()->first();
        $latestWeather = WeatherData::latest()->first();
        $latestWater = WaterData::latest()->first();

        return view('ar.index', compact('latestSoil', 'latestWeather', 'latestWater'));
    }
}
