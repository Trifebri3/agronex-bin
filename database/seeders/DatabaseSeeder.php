<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoilData;
use App\Models\WaterData;
use App\Models\WeatherData;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with initial sensor data.
     */
    public function run(): void
    {
        // 1. Seed Soil Data (20 records over past hours)
        $now = Carbon::now();
        for ($i = 20; $i >= 0; $i--) {
            $time = (clone $now)->subMinutes($i * 10);
            SoilData::create([
                'kelembapan' => round(55.0 + sin($i * 0.5) * 6 + mt_rand(-10, 10) / 10, 1),
                'suhu' => round(27.5 + cos($i * 0.4) * 2 + mt_rand(-5, 5) / 10, 1),
                'ec' => round(720 + sin($i * 0.3) * 60 + mt_rand(-20, 20)),
                'ph' => round(6.8 + sin($i * 0.2) * 0.3 + mt_rand(-1, 1) / 10, 2),
                'nitrogen' => round(52 + sin($i * 0.5) * 8 + mt_rand(-3, 3)),
                'fosfor' => round(34 + cos($i * 0.5) * 5 + mt_rand(-2, 2)),
                'kalium' => round(135 + sin($i * 0.3) * 15 + mt_rand(-5, 5)),
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }

        // 2. Seed Water Data (20 records)
        for ($i = 20; $i >= 0; $i--) {
            $time = (clone $now)->subMinutes($i * 10);
            WaterData::create([
                'suhu' => round(26.8 + sin($i * 0.4) * 1.2 + mt_rand(-3, 3) / 10, 2),
                'ph' => round(7.25 + cos($i * 0.3) * 0.25 + mt_rand(-2, 2) / 10, 2),
                'tds' => round(240 + sin($i * 0.5) * 35 + mt_rand(-10, 10), 2),
                'turbidity' => round(5.8 + cos($i * 0.4) * 2.1 + mt_rand(-5, 5) / 10, 2),
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }

        // 3. Seed Weather Data (20 records)
        for ($i = 20; $i >= 0; $i--) {
            $time = (clone $now)->subMinutes($i * 10);
            WeatherData::create([
                'suhu' => round(28.5 + sin($i * 0.4) * 3.5 + mt_rand(-5, 5) / 10, 1),
                'kelembapan' => round(72.0 - sin($i * 0.4) * 10 + mt_rand(-10, 10) / 10, 1),
                'tekanan' => round(1012.0 + cos($i * 0.2) * 2.5, 1),
                'cahaya' => max(0, round(42000 + sin($i * 0.3) * 18000 + mt_rand(-1000, 1000))),
                'kecepatan_angin' => round(3.2 + sin($i * 0.6) * 1.4 + mt_rand(-3, 3) / 10, 1),
                'curah_hujan' => ($i % 7 === 0) ? mt_rand(1, 4) : 0,
                'dew_point' => round(23.1 + sin($i * 0.3) * 1.1, 1),
                'et0' => round(4.1 + sin($i * 0.4) * 0.6, 2),
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }
    }
}
