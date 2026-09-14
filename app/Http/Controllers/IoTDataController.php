<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IoTDataController extends Controller
{
    public function index()
    {
        // 1. Fetch map settings from admin config
        $polygon_coords = \App\Models\Setting::where('key', 'polygon_coords')->value('value') ?? '[]';
        $soil_lat = \App\Models\Setting::where('key', 'soil_lat')->value('value') ?? '-6.914744';
        $soil_lng = \App\Models\Setting::where('key', 'soil_lng')->value('value') ?? '107.609810';
        $soil_photo = \App\Models\Setting::where('key', 'soil_photo')->value('value') ?? '';
        $soil_desc = \App\Models\Setting::where('key', 'soil_desc')->value('value') ?? '';

        $weather_lat = \App\Models\Setting::where('key', 'weather_lat')->value('value') ?? '-6.914500';
        $weather_lng = \App\Models\Setting::where('key', 'weather_lng')->value('value') ?? '107.609500';
        $weather_photo = \App\Models\Setting::where('key', 'weather_photo')->value('value') ?? '';
        $weather_desc = \App\Models\Setting::where('key', 'weather_desc')->value('value') ?? '';

        $water_lat = \App\Models\Setting::where('key', 'water_lat')->value('value') ?? '-6.915000';
        $water_lng = \App\Models\Setting::where('key', 'water_lng')->value('value') ?? '107.610000';
        $water_photo = \App\Models\Setting::where('key', 'water_photo')->value('value') ?? '';
        $water_desc = \App\Models\Setting::where('key', 'water_desc')->value('value') ?? '';

        $terranir_lat = \App\Models\Setting::where('key', 'terranir_lat')->value('value') ?? '-6.914200';
        $terranir_lng = \App\Models\Setting::where('key', 'terranir_lng')->value('value') ?? '107.610500';
        $terranir_photo = \App\Models\Setting::where('key', 'terranir_photo')->value('value') ?? '';
        $terranir_desc = \App\Models\Setting::where('key', 'terranir_desc')->value('value') ?? '';

        $kawasan_desc = \App\Models\Setting::where('key', 'kawasan_desc')->value('value') ?? 'Lahan Pertanian Agronex';
        $kawasan_photo = \App\Models\Setting::where('key', 'kawasan_photo')->value('value') ?? '';

        // 2. Fetch real data for display
        $latestSoil = \App\Models\SoilData::latest()->first();
        $latestWeather = \App\Models\WeatherData::latest()->first();
        $latestWater = \App\Models\WaterData::latest()->first();

        // Decision Engine Logic
        $statusGlobal = 'BAIK';
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
        if ($latestSoil) {
            if ($latestSoil->kelembapan < 40) {
                $statusGlobal = 'PERHATIAN';
                $issues[] = ['title' => 'Kelembapan Rendah', 'desc' => 'Tanah mulai kering (' . $latestSoil->kelembapan . '%).', 'action' => 'Disarankan irigasi ± 20 menit.', 'icon' => 'water', 'type' => 'water', 'time' => '16.00 WIB'];
            }
            if ($latestSoil->nitrogen < 40) {
                $statusGlobal = 'PERHATIAN';
                $issues[] = ['title' => 'Kadar Nitrogen Rendah', 'desc' => 'Nitrogen terdeteksi ' . $latestSoil->nitrogen . ' mg/kg.', 'action' => 'Periksa jadwal pemupukan.', 'icon' => 'plant', 'type' => 'fertilizer', 'time' => 'Sebelum sore'];
            }
        }

        if ($latestWeather) {
            if ($latestWeather->curah_hujan > 0) {
                $issues[] = ['title' => 'Hujan Turun', 'desc' => 'Terdeteksi curah hujan.', 'action' => 'Tunda penyiraman.', 'icon' => 'cloud', 'type' => 'weather', 'time' => '-'];
            } elseif ($latestWeather->suhu > 34) {
                $statusGlobal = 'TINDAKAN';
                $issues[] = ['title' => 'Cuaca Ekstrem (Panas)', 'desc' => 'Suhu ' . $latestWeather->suhu . ' °C.', 'action' => 'Segera cek naungan atau lakukan penyiraman ekstra.', 'icon' => 'alert', 'type' => 'check', 'time' => 'Segera'];
            }
        }

        if (count($issues) > 0) {
            if ($statusGlobal == 'TINDAKAN') {
                $globalColor = 'red';
                $globalMessage = 'Segera lakukan tindakan! Ada ' . count($issues) . ' hal kritis yang perlu ditangani.';
            } else {
                $globalMessage = 'Ada ' . count($issues) . ' hal yang perlu Anda perhatikan hari ini.';
                $globalColor = 'amber';
            }
        }
        } // End of else block for !isDelayed

        // 3. Build sensors array with real data
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

        return view('iot.index', compact(
            'polygon_coords', 
            'kawasan_desc', 'kawasan_photo',
            'sensors',
            'soil_lat', 'soil_lng', 'soil_photo', 'soil_desc',
            'weather_lat', 'weather_lng', 'weather_photo', 'weather_desc',
            'water_lat', 'water_lng', 'water_photo', 'water_desc',
            'terranir_lat', 'terranir_lng', 'terranir_photo', 'terranir_desc',
            'statusGlobal', 'globalMessage', 'globalColor', 'issues'
        ));
    }

    public function waterDetail()
    {
        $history = \App\Models\WaterData::latest()->paginate(10);
        
        // Take 20 for chart
        $chartData = \App\Models\WaterData::latest()->take(20)->get()->reverse()->values();

        $latest = $history->first();
        $defaultLat = \App\Models\Setting::where('key', 'sensor_latitude')->value('value') ?? '-6.914744';
        $defaultLng = \App\Models\Setting::where('key', 'sensor_longitude')->value('value') ?? '107.609810';

        $lat = ($latest && $latest->latitude) ? $latest->latitude : $defaultLat;
        $lng = ($latest && $latest->longitude) ? $latest->longitude : $defaultLng;

        return view('iot.water', compact('history', 'chartData', 'lat', 'lng', 'latest'));
    }

    public function waterDownload()
    {
        $data = \App\Models\WaterData::orderBy('created_at', 'desc')->get();

        $csvFileName = 'kualitas_air_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $handle = fopen('php://output', 'w');
        ob_start();
        fputcsv($handle, ['Waktu', 'Suhu (C)', 'pH', 'TDS (ppm)', 'Turbidity (NTU)', 'Latitude', 'Longitude']);

        foreach ($data as $row) {
            fputcsv($handle, [
                $row->created_at->format('Y-m-d H:i:s'),
                $row->suhu,
                $row->ph,
                $row->tds,
                $row->turbidity,
                $row->latitude,
                $row->longitude
            ]);
        }

        fclose($handle);
        $csvContent = ob_get_clean();

        return response($csvContent, 200, $headers);
    }

    public function weatherDetail()
    {
        $history = \App\Models\WeatherData::latest()->paginate(10);
        
        // Take 20 for chart
        $chartData = \App\Models\WeatherData::latest()->take(20)->get()->reverse()->values();

        $latest = $history->first();
        $defaultLat = \App\Models\Setting::where('key', 'sensor_latitude')->value('value') ?? '-6.914744';
        $defaultLng = \App\Models\Setting::where('key', 'sensor_longitude')->value('value') ?? '107.609810';

        $lat = ($latest && $latest->latitude) ? $latest->latitude : $defaultLat;
        $lng = ($latest && $latest->longitude) ? $latest->longitude : $defaultLng;

        return view('iot.weather', compact('history', 'chartData', 'lat', 'lng', 'latest'));
    }

    public function weatherDownload()
    {
        $data = \App\Models\WeatherData::orderBy('created_at', 'desc')->get();

        $csvFileName = 'cuaca_lingkungan_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $handle = fopen('php://output', 'w');
        ob_start();
        fputcsv($handle, ['Waktu', 'Suhu (C)', 'Kelembapan (%)', 'Tekanan (hPa)', 'Cahaya (Lux)', 'Kecepatan Angin (m/s)', 'Hujan (mm)', 'Dew Point (C)', 'ET0 (mm)', 'Latitude', 'Longitude']);

        foreach ($data as $row) {
            fputcsv($handle, [
                $row->created_at->format('Y-m-d H:i:s'),
                $row->suhu,
                $row->kelembapan,
                $row->tekanan_udara,
                $row->cahaya_lux,
                $row->kecepatan_angin,
                $row->curah_hujan,
                $row->dew_point,
                $row->et0,
                $row->latitude,
                $row->longitude
            ]);
        }

        fclose($handle);
        $csvContent = ob_get_clean();

        return response($csvContent, 200, $headers);
    }

    public function soilDetail()
    {
        $history = \App\Models\SoilData::latest()->paginate(10);
        
        // Take 20 for chart
        $chartData = \App\Models\SoilData::latest()->take(20)->get()->reverse()->values();

        $latest = $history->first();
        $defaultLat = \App\Models\Setting::where('key', 'sensor_latitude')->value('value') ?? '-6.914744';
        $defaultLng = \App\Models\Setting::where('key', 'sensor_longitude')->value('value') ?? '107.609810';

        $lat = ($latest && $latest->latitude) ? $latest->latitude : $defaultLat;
        $lng = ($latest && $latest->longitude) ? $latest->longitude : $defaultLng;

        return view('iot.soilsense', compact('history', 'chartData', 'lat', 'lng', 'latest'));
    }

    public function soilDownload()
    {
        $data = \App\Models\SoilData::orderBy('created_at', 'desc')->get();

        $csvFileName = 'kualitas_tanah_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $handle = fopen('php://output', 'w');
        ob_start();
        fputcsv($handle, ['Waktu', 'Kelembapan (%)', 'Suhu (C)', 'EC (uS/cm)', 'pH', 'Nitrogen (mg/kg)', 'Fosfor (mg/kg)', 'Kalium (mg/kg)', 'Latitude', 'Longitude']);

        foreach ($data as $row) {
            fputcsv($handle, [
                $row->created_at->format('Y-m-d H:i:s'),
                $row->kelembapan,
                $row->suhu,
                $row->ec,
                $row->ph,
                $row->nitrogen,
                $row->fosfor,
                $row->kalium,
                $row->latitude,
                $row->longitude
            ]);
        }

        fclose($handle);
        $csvContent = ob_get_clean();

        return response($csvContent, 200, $headers);
    }

    public function terranirDetail()
    {
        return view('iot.terranir');
    }
}
