<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WaterData;
use Illuminate\Http\Request;

class WaterDataController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'suhu' => 'required|numeric',
            'ph' => 'required|numeric',
            'tds' => 'required|numeric',
            'turbidity' => 'required|numeric',
        ]);

        // Auto/Static Coordinate (since ESP32 code didn't provide GPS)
        // Set to a dummy farm location
        $lat = '-6.914744'; 
        $lng = '107.609810';

        $data = WaterData::create([
            'suhu' => $request->suhu,
            'ph' => $request->ph,
            'tds' => $request->tds,
            'turbidity' => $request->turbidity,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $data
        ], 201);
    }
}
