<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use Illuminate\Http\Request;

class WeatherDashboardController extends Controller
{
    public function index()
    {
        $latest = WeatherData::latest('id')->first();

        $history = WeatherData::latest('id')
            ->limit(20)
            ->get()
            ->reverse()
            ->values();

        return view('weather.dashboard', compact(
            'latest',
            'history'
        ));
    }

    public function latest()
    {
        $latest = WeatherData::latest('id')->first();

        return response()->json([
            'success' => true,
            'data' => $latest,
        ]);
    }

    public function history()
    {
        $history = WeatherData::latest('id')
            ->limit(20)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }
}