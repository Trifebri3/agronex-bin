<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data terbaru dari sensor dan cuaca
        $latestSoil = \App\Models\SoilData::latest()->first();
        $latestWeather = \App\Models\WeatherData::latest()->first();

        // 2. Decision Engine Logic
        $statusGlobal = 'BAIK'; // BAIK, PERHATIAN, TINDAKAN
        $globalMessage = 'Kondisi tanaman dan lahan cukup sehat hari ini. Tidak ada tindakan mendesak yang diperlukan.';
        $globalColor = 'emerald';
        $issues = [];

        // Check for Data Delay (Older than 60 minutes)
        $isDelayed = false;
        if ($latestSoil && $latestSoil->created_at->diffInMinutes(now()) > 60) {
            $isDelayed = true;
        }
        if ($latestWeather && $latestWeather->created_at->diffInMinutes(now()) > 60) {
            $isDelayed = true;
        }

        if ($isDelayed) {
            $statusGlobal = 'PERHATIAN';
            $globalMessage = 'Sensor sedang offline atau data terlambat. Rekomendasi dihentikan sementara karena data saat ini kurang akurat (delay).';
            $globalColor = 'slate';
        } else {
            // Check Soil Moisture
        if ($latestSoil) {
            if ($latestSoil->kelembapan < 40) {
                $statusGlobal = 'PERHATIAN';
                $issues[] = [
                    'title' => 'Kelembapan Rendah',
                    'desc' => 'Tanah mulai kering (' . $latestSoil->kelembapan . '%).',
                    'action' => 'Disarankan irigasi ± 20 menit.',
                    'icon' => 'water',
                    'type' => 'water',
                    'time' => '16.00 WIB'
                ];
            }

            // Check NPK
            if ($latestSoil->nitrogen < 40) {
                $statusGlobal = 'PERHATIAN';
                $issues[] = [
                    'title' => 'Kadar Nitrogen Rendah',
                    'desc' => 'Nitrogen terdeteksi ' . $latestSoil->nitrogen . ' mg/kg.',
                    'action' => 'Periksa jadwal pemupukan.',
                    'icon' => 'plant',
                    'type' => 'fertilizer',
                    'time' => 'Sebelum sore'
                ];
            }
        }

        // Check Weather
        if ($latestWeather) {
            if ($latestWeather->curah_hujan > 0) {
                $issues[] = [
                    'title' => 'Hujan Turun',
                    'desc' => 'Terdeteksi curah hujan.',
                    'action' => 'Tunda penyiraman.',
                    'icon' => 'cloud',
                    'type' => 'weather',
                    'time' => '-'
                ];
                // Kalo hujan, berarti kelembapan rendah tadi bisa diabaikan
            } elseif ($latestWeather->suhu > 34) {
                $statusGlobal = 'TINDAKAN';
                $issues[] = [
                    'title' => 'Cuaca Ekstrem (Panas)',
                    'desc' => 'Suhu ' . $latestWeather->suhu . ' °C.',
                    'action' => 'Segera cek naungan atau lakukan penyiraman ekstra.',
                    'icon' => 'alert',
                    'type' => 'check',
                    'time' => 'Segera'
                ];
            }
        }

        if (count($issues) > 0) {
            if ($statusGlobal == 'TINDAKAN') {
                $globalColor = 'red';
                $globalMessage = 'Segera lakukan tindakan! Ada ' . count($issues) . ' hal kritis yang perlu ditangani.';
            } else {
                $globalMessage = 'Ada ' . count($issues) . ' hal yang perlu Anda perhatikan hari ini.';
                $globalColor = 'amber'; // Kuning
            }
        }
        } // End of else block for !isDelayed

        // Update Action Plans (Dummy generation for today based on issues)
        $actionPlans = [];
        foreach($issues as $issue) {
            if ($issue['type'] != 'weather') {
                $actionPlans[] = [
                    'id' => rand(1, 1000),
                    'title' => $issue['action'],
                    'priority' => $statusGlobal == 'TINDAKAN' ? 'high' : 'normal',
                    'time' => $issue['time'],
                    'is_completed' => false
                ];
            }
        }

        // Ambil Data Profil Lahan
        $farm_name = \App\Models\Setting::where('key', 'farm_name')->value('value') ?? 'Sawah Cisewu';
        $crop_type = \App\Models\Setting::where('key', 'crop_type')->value('value') ?? 'Padi';
        $farm_area = \App\Models\Setting::where('key', 'farm_area')->value('value') ?? '0,8';

        return view('dashboard.index', compact('statusGlobal', 'globalMessage', 'globalColor', 'issues', 'actionPlans', 'latestSoil', 'latestWeather', 'farm_name', 'crop_type', 'farm_area'));
    }

    public function checkActionPlan(Request $request) {
        // Dummy toggle for now, in real app update database
        return response()->json(['success' => true]);
    }
}
