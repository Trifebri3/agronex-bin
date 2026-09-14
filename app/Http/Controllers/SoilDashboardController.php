<?php

namespace App\Http\Controllers;

use App\Models\SoilData;
use Illuminate\Http\Request;

class SoilDashboardController extends Controller
{
    public function index()
    {
        $latest = SoilData::latest('id')->first();

        $history = SoilData::latest('id')
            ->limit(20)
            ->get()
            ->reverse()
            ->values();

        return view('soil.dashboard', compact('latest', 'history'));
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
