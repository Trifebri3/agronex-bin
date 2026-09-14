<?php

namespace App\Http\Controllers;

use App\Models\SoilData;
use Illuminate\Http\Request;

class SoilDataController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelembapan' => 'required|numeric',
            'suhu' => 'required|numeric',
            'ec' => 'required|numeric',
            'ph' => 'required|numeric',
            'nitrogen' => 'required|numeric',
            'fosfor' => 'required|numeric',
            'kalium' => 'required|numeric',
        ]);

        $lat = \App\Models\Setting::where('key', 'sensor_latitude')->value('value') ?? '-6.914744'; 
        $lng = \App\Models\Setting::where('key', 'sensor_longitude')->value('value') ?? '107.609810';

        $data = SoilData::create(array_merge($validated, [
            'latitude' => $lat,
            'longitude' => $lng
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data tanah berhasil disimpan',
            'data' => $data,
        ], 201);
    }

    public function index()
    {
        $data = SoilData::latest('id')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function latest()
    {
        $data = SoilData::latest('id')->first();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function history()
    {
        $data = SoilData::latest('id')
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