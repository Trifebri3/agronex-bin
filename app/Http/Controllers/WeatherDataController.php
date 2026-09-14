<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use Illuminate\Http\Request;

class WeatherDataController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'tekanan' => 'required|numeric',
            'cahaya' => 'required|numeric',
            'kecepatan_angin' => 'required|numeric',
            'curah_hujan' => 'required|integer',
            'dew_point' => 'required|numeric',
            'et0' => 'required|numeric',
        ]);

        $lat = \App\Models\Setting::where('key', 'sensor_latitude')->value('value') ?? '-6.914744'; 
        $lng = \App\Models\Setting::where('key', 'sensor_longitude')->value('value') ?? '107.609810';

        $data = WeatherData::create(array_merge($validated, [
            'latitude' => $lat,
            'longitude' => $lng,
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data cuaca berhasil disimpan',
            'data' => $data,
        ], 201);
    }

    public function index()
    {
        $data = WeatherData::latest('id')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function latest()
    {
        $data = WeatherData::latest('id')->first();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function history()
    {
        $data = WeatherData::latest('id')
            ->limit(20)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}