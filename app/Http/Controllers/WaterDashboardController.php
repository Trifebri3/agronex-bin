<?php

namespace App\Http\Controllers;

use App\Models\WaterData;
use Illuminate\Http\Request;

class WaterDashboardController extends Controller
{
    public function index()
    {
        $latest = WaterData::latest('id')->first();

        $history = WaterData::latest('id')
            ->limit(20)
            ->get()
            ->reverse()
            ->values();

        return view('water.dashboard', compact('latest', 'history'));
    }

    public function latest()
    {
        $latest = WaterData::latest('id')->first();

        return response()->json([
            'success' => true,
            'data' => $latest,
        ]);
    }

    public function history()
    {
        $history = WaterData::latest('id')
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
