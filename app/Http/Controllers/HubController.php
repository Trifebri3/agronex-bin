<?php

namespace App\Http\Controllers;

use App\Models\SoilData;
use App\Models\WaterData;
use App\Models\WeatherData;
use Illuminate\Http\Request;

class HubController extends Controller
{
    /**
     * Display the Unified Multi-Dashboard Hub with Contextual Intelligence.
     */
    public function index()
    {
        $latestSoil = SoilData::latest('id')->first();
        $latestWater = WaterData::latest('id')->first();
        $latestWeather = WeatherData::latest('id')->first();

        $totalSoilCount = SoilData::count();
        $totalWaterCount = WaterData::count();
        $totalWeatherCount = WeatherData::count();

        // 1. Contextual Analysis: Soil
        $soilHealth = 'Optimal';
        $soilAdvice = 'Kadar air dan nutrisi tanah dalam kondisi sangat baik untuk penyerapan akar.';
        if ($latestSoil) {
            if ($latestSoil->kelembapan < 35) {
                $soilHealth = 'Kering (Perlu Disiram)';
                $soilAdvice = 'Kelembapan tanah rendah. Disarankan mengaktifkan sistem irigasi tetes atau penyiraman berkala.';
            } elseif ($latestSoil->kelembapan > 80) {
                $soilHealth = 'Terlalu Basah (Risiko Genangan)';
                $soilAdvice = 'Tanah sangat basah. Periksa saluran drainase bedengan agar akar tidak membusuk.';
            } elseif ($latestSoil->ph < 6.0) {
                $soilHealth = 'Tanah Asam';
                $soilAdvice = 'pH tanah cenderung masam. Pertimbangkan pemberian kapur pertanian (dolomit) saat pemupukan berikutnya.';
            }
        }

        // 2. Contextual Analysis: Water
        $waterHealth = 'Normal & Bersih';
        $waterAdvice = 'Kualitas air aman dan ideal untuk ekosistem perairan dan kebutuhan budidaya.';
        if ($latestWater) {
            if ($latestWater->turbidity > 25) {
                $waterHealth = 'Air Keruh';
                $waterAdvice = 'Tingkat kekeruhan meningkat. Lakukan pengendapan atau pengecekan filter sebelum dialirkan ke kolam.';
            } elseif ($latestWater->ph < 6.5 || $latestWater->ph > 8.5) {
                $waterHealth = 'pH di Luar Ambang Batas';
                $waterAdvice = 'Derajat keasaman air tidak stabil. Berikan buffer alami atau penstabil air untuk menjaga kelangsungan bibit.';
            } elseif ($latestWater->tds > 500) {
                $waterHealth = 'TDS Tinggi';
                $waterAdvice = 'Kandungan zat padat terlarut cukup pekat. Perlu sirkulasi air segar tambahan.';
            }
        }

        // 3. Contextual Analysis: Weather
        $weatherHealth = 'Cerah & Kondusif';
        $weatherAdvice = 'Kondisi mikroklimat stabil. Waktu yang baik untuk perawatan tanaman dan aktivitas luar ruangan.';
        if ($latestWeather) {
            if ($latestWeather->curah_hujan > 20) {
                $weatherHealth = 'Hujan Deras Terdeteksi';
                $weatherAdvice = 'Intensitas hujan cukup tinggi. Tunda pemupukan daun agar nutrisi tidak terbuang terbawa air.';
            } elseif ($latestWeather->curah_hujan > 0) {
                $weatherHealth = 'Hujan Ringan / Gerimis';
                $weatherAdvice = 'Terdapat presipitasi ringan. Pompa penyiraman lahan dapat dikurangi durasinya.';
            } elseif ($latestWeather->suhu > 34) {
                $weatherHealth = 'Panas Terik';
                $weatherAdvice = 'Laju penguapan meningkat pesat. Pastikan peneduh atau suplai air mencukupi pada siang hari.';
            }
        }

        // 4. Holistic Synthesis: Kesimpulan Terpadu
        $ecosystemVerdict = 'Seluruh Node Beroperasi Prima';
        $ecosystemBadge = 'optimal';
        if ($soilHealth !== 'Optimal' || str_contains($waterHealth, 'Perlu') || str_contains($weatherHealth, 'Hujan Deras')) {
            $ecosystemVerdict = 'Perhatian Khusus Diperlukan pada Beberapa Parameter';
            $ecosystemBadge = 'warning';
        }

        return view('hub.index', compact(
            'latestSoil',
            'latestWater',
            'latestWeather',
            'totalSoilCount',
            'totalWaterCount',
            'totalWeatherCount',
            'soilHealth',
            'soilAdvice',
            'waterHealth',
            'waterAdvice',
            'weatherHealth',
            'weatherAdvice',
            'ecosystemVerdict',
            'ecosystemBadge'
        ));
    }

    /**
     * Live Polling Status with Conversational Messages.
     */
    public function status()
    {
        $latestSoil = SoilData::latest('id')->first();
        $latestWater = WaterData::latest('id')->first();
        $latestWeather = WeatherData::latest('id')->first();

        return response()->json([
            'success' => true,
            'timestamp' => now()->toIso8601String(),
            'formatted_time' => now()->format('H:i:s'),
            'soil' => [
                'latest' => $latestSoil,
                'count' => SoilData::count(),
            ],
            'water' => [
                'latest' => $latestWater,
                'count' => WaterData::count(),
            ],
            'weather' => [
                'latest' => $latestWeather,
                'count' => WeatherData::count(),
            ],
        ]);
    }

    /**
     * Tactile Prototyping: Realistic Scenario Simulation Presets.
     */
    public function simulate(Request $request)
    {
        $scenario = $request->query('scenario', $request->query('type', 'ideal'));
        $created = [];
        $message = '';

        if ($scenario === 'kemarau') {
            // Skenario 1: Kemarau Panjang & Panas Terik
            $created['soil'] = SoilData::create([
                'kelembapan' => round(mt_rand(200, 290) / 10, 1),
                'suhu' => round(mt_rand(320, 350) / 10, 1),
                'ec' => mt_rand(950, 1400),
                'ph' => round(mt_rand(62, 70) / 10, 2),
                'nitrogen' => mt_rand(25, 45),
                'fosfor' => mt_rand(20, 35),
                'kalium' => mt_rand(90, 130),
            ]);
            $created['water'] = WaterData::create([
                'suhu' => round(mt_rand(300, 325) / 10, 2),
                'ph' => round(mt_rand(74, 82) / 10, 2),
                'tds' => round(mt_rand(450, 620), 2),
                'turbidity' => round(mt_rand(12, 22), 2),
            ]);
            $created['weather'] = WeatherData::create([
                'suhu' => round(mt_rand(350, 380) / 10, 1),
                'kelembapan' => round(mt_rand(380, 480) / 10, 1),
                'tekanan' => round(mt_rand(10080, 10110) / 10, 1),
                'cahaya' => mt_rand(75000, 95000),
                'kecepatan_angin' => round(mt_rand(45, 75) / 10, 1),
                'curah_hujan' => 0,
                'dew_point' => round(mt_rand(190, 210) / 10, 1),
                'et0' => round(mt_rand(60, 75) / 10, 2),
            ]);
            $message = 'Skenario Kemarau Diterapkan: Suhu tinggi, kelembapan tanah rendah, evaporasi meningkat.';

        } elseif ($scenario === 'hujan') {
            // Skenario 2: Hujan Deras & Lembap Ekstrem
            $created['soil'] = SoilData::create([
                'kelembapan' => round(mt_rand(820, 920) / 10, 1),
                'suhu' => round(mt_rand(220, 245) / 10, 1),
                'ec' => mt_rand(500, 700),
                'ph' => round(mt_rand(64, 70) / 10, 2),
                'nitrogen' => mt_rand(40, 60),
                'fosfor' => mt_rand(25, 45),
                'kalium' => mt_rand(110, 150),
            ]);
            $created['water'] = WaterData::create([
                'suhu' => round(mt_rand(230, 255) / 10, 2),
                'ph' => round(mt_rand(67, 72) / 10, 2),
                'tds' => round(mt_rand(140, 210), 2),
                'turbidity' => round(mt_rand(35, 55), 2), // keruh karena limpasan air
            ]);
            $created['weather'] = WeatherData::create([
                'suhu' => round(mt_rand(230, 260) / 10, 1),
                'kelembapan' => round(mt_rand(880, 960) / 10, 1),
                'tekanan' => round(mt_rand(10050, 10090) / 10, 1),
                'cahaya' => mt_rand(8000, 18000),
                'kecepatan_angin' => round(mt_rand(60, 110) / 10, 1),
                'curah_hujan' => mt_rand(35, 65),
                'dew_point' => round(mt_rand(230, 250) / 10, 1),
                'et0' => round(mt_rand(18, 28) / 10, 2),
            ]);
            $message = 'Skenario Hujan Deras Diterapkan: Curah hujan tinggi, tanah jenuh air, kekeruhan air meningkat.';

        } elseif ($scenario === 'tercemar') {
            // Skenario 3: Gangguan Kualitas Air (Acidic / Turbid)
            $created['water'] = WaterData::create([
                'suhu' => round(mt_rand(270, 290) / 10, 2),
                'ph' => round(mt_rand(48, 56) / 10, 2), // asam tidak normal
                'tds' => round(mt_rand(780, 1100), 2), // padatan terlarut sangat tinggi
                'turbidity' => round(mt_rand(48, 75), 2), // air sangat keruh
            ]);
            $message = 'Skenario Air Tercemar Diterapkan: pH turun asam, TDS dan kekeruhan melonjak tinggi!';

        } else {
            // Skenario 4: Kondisi Ideal & Seimbang (Default)
            $created['soil'] = SoilData::create([
                'kelembapan' => round(mt_rand(580, 680) / 10, 1),
                'suhu' => round(mt_rand(260, 285) / 10, 1),
                'ec' => mt_rand(650, 850),
                'ph' => round(mt_rand(65, 72) / 10, 2),
                'nitrogen' => mt_rand(50, 70),
                'fosfor' => mt_rand(30, 48),
                'kalium' => mt_rand(130, 170),
            ]);
            $created['water'] = WaterData::create([
                'suhu' => round(mt_rand(260, 278) / 10, 2),
                'ph' => round(mt_rand(71, 76) / 10, 2),
                'tds' => round(mt_rand(210, 280), 2),
                'turbidity' => round(mt_rand(35, 65) / 10, 2),
            ]);
            $created['weather'] = WeatherData::create([
                'suhu' => round(mt_rand(275, 295) / 10, 1),
                'kelembapan' => round(mt_rand(650, 750) / 10, 1),
                'tekanan' => round(mt_rand(10110, 10140) / 10, 1),
                'cahaya' => mt_rand(35000, 55000),
                'kecepatan_angin' => round(mt_rand(25, 45) / 10, 1),
                'curah_hujan' => 0,
                'dew_point' => round(mt_rand(220, 235) / 10, 1),
                'et0' => round(mt_rand(35, 45) / 10, 2),
            ]);
            $message = 'Skenario Normal Diterapkan: Seluruh parameter berada pada rentang acuan.';
        }

        return response()->json([
            'success' => true,
            'scenario' => $scenario,
            'message' => $message,
            'data' => $created,
        ]);
    }
}
