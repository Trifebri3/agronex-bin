<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoilData;
use App\Models\WeatherData;
use App\Models\WaterData;

class LabController extends Controller
{
    public function index()
    {
        $latestSoil = SoilData::latest()->first();
        $latestWeather = WeatherData::latest()->first();
        $latestWater = WaterData::latest()->first();

        $sensors = [
            [
                'id' => 'soil',
                'name' => 'SoilSense',
                'type' => 'soil',
                'status' => 'Realtime',
                'value' => $latestSoil ? $latestSoil->kelembapan . '%' : '-',
                'condition' => $latestSoil ? ($latestSoil->kelembapan > 40 ? 'Normal' : 'Kering') : '-',
                'color' => 'emerald'
            ],
            [
                'id' => 'weather',
                'name' => 'EnviroSense',
                'type' => 'weather',
                'status' => 'Realtime',
                'value' => $latestWeather ? $latestWeather->suhu . '°C' : '-',
                'condition' => $latestWeather ? ($latestWeather->suhu > 34 ? 'Panas' : 'Normal') : '-',
                'color' => 'orange'
            ],
            [
                'id' => 'water',
                'name' => 'WaterSense',
                'type' => 'water',
                'status' => 'Realtime',
                'value' => $latestWater ? 'pH ' . $latestWater->ph : '-',
                'condition' => $latestWater ? ($latestWater->ph >= 6.5 && $latestWater->ph <= 7.5 ? 'Baik' : 'Perhatian') : '-',
                'color' => 'blue'
            ],
            [
                'id' => 'terranir',
                'name' => 'TerraNIR',
                'type' => 'terranir',
                'status' => 'Coming Soon',
                'value' => '-',
                'condition' => '-',
                'color' => 'purple'
            ]
        ];

        return view('lab.index', compact('sensors'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'plant_type' => 'required',
            'actions_done' => 'required|array'
        ]);

        $plantType = $request->plant_type;
        $actionsDone = $request->actions_done;

        // Fetch latest sensor data for smart analysis
        $latestSoil = SoilData::latest()->first();
        $latestWeather = WeatherData::latest()->first();

        // Check if sensor data is too old (> 60 mins)
        $isDelayed = false;
        if ($latestSoil && $latestSoil->created_at->diffInMinutes(now()) > 60) {
            $isDelayed = true;
        }
        if ($latestWeather && $latestWeather->created_at->diffInMinutes(now()) > 60) {
            $isDelayed = true;
        }

        // Logic for LAB analysis
        $recommendations = [];
        $status = 'BAIK'; // BAIK, PERHATIAN, TINDAKAN

        if ($isDelayed) {
            $recommendations[] = [
                'title' => 'Peringatan Sensor Offline',
                'desc' => 'Sensor IoT belum mengirim data baru dalam 1 jam terakhir. Rekomendasi di bawah mungkin kurang akurat.'
            ];
            $status = 'PERHATIAN';
        }

        // Dummy rules mapping for demonstration
        if (in_array('memupuk_urea', $actionsDone)) {
            if ($latestSoil && $latestSoil->nitrogen > 50) {
                $recommendations[] = [
                    'title' => 'Resiko Over-Fertilisasi',
                    'desc' => 'Kadar Nitrogen tanah Anda cukup tinggi (' . $latestSoil->nitrogen . ' mg/kg). Tambahan Urea bisa menyebabkan pertumbuhan daun berlebih tanpa buah.'
                ];
                $status = 'PERHATIAN';
            } else {
                $recommendations[] = [
                    'title' => 'Pemupukan Tepat',
                    'desc' => 'Pemberian pupuk Urea sangat tepat untuk mendukung pertumbuhan vegetatif.'
                ];
            }
        }

        if (in_array('menyiram', $actionsDone)) {
            if ($latestSoil && $latestSoil->kelembapan > 70) {
                $recommendations[] = [
                    'title' => 'Tanah Terlalu Basah',
                    'desc' => 'Kelembapan tanah saat ini ' . $latestSoil->kelembapan . '%. Menyiram tambahan dapat menyebabkan akar busuk.'
                ];
                $status = 'TINDAKAN';
            }
        }

        // If no specific warnings were generated
        if (empty($recommendations)) {
            $recommendations[] = [
                'title' => 'Tindakan Sesuai',
                'desc' => 'Berdasarkan data IoT, tindakan yang Anda lakukan sudah sesuai dan kondisi tanaman (' . $plantType . ') diprediksi aman.'
            ];
        }

        return view('lab.result', compact('plantType', 'actionsDone', 'recommendations', 'status', 'latestSoil', 'latestWeather', 'isDelayed'));
    }
}
