<?php

namespace App\Http\Controllers;

use App\Models\WaterData;
use Illuminate\Http\Request;

class WaterDataController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'ph' => 'required|numeric',
            'tds' => 'required|numeric',
            'turbidity' => 'required|numeric',
        ]);

        $lat = \App\Models\Setting::where('key', 'sensor_latitude')->value('value') ?? '-6.914744'; 
        $lng = \App\Models\Setting::where('key', 'sensor_longitude')->value('value') ?? '107.609810';

        $data = WaterData::create(array_merge($validated, [
            'latitude' => $lat,
            'longitude' => $lng,
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $data,
        ], 201);
    }

    public function index()
    {
        return response()->json(
            WaterData::latest()->get()
        );
    }

    public function latest()
    {
        $data = WaterData::latest()->first();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}