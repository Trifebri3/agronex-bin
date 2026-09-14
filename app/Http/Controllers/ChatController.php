<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Setting;
use App\Models\SoilData;
use App\Models\WeatherData;
use App\Models\WaterData;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function send(Request $request)
    {
        $message = $request->input('message');
        
        // Fetch AI configs from Database
        $encrypted_key = Setting::where('key', 'ai_api_key')->value('value');
        $openRouterKey = '';
        if ($encrypted_key) {
            try {
                $openRouterKey = Crypt::decryptString($encrypted_key);
            } catch (\Exception $e) {
                $openRouterKey = '';
            }
        }

        $ai_model = Setting::where('key', 'ai_model')->value('value') ?? 'google/gemini-2.5-flash';
        $ai_system_prompt = Setting::where('key', 'ai_system_prompt')->value('value') ?? 'Kamu adalah asisten AI ahli pertanian bernama Agronex AI. Jawab dalam bahasa Indonesia, ramah, dan ringkas.';

        // Inject real-time sensor data into the prompt
        $latestSoil = SoilData::latest()->first();
        $latestWeather = WeatherData::latest()->first();
        $latestWater = WaterData::latest()->first();

        $sensorContext = "\n\n--- DATA SENSOR SAAT INI (REALTIME) ---\n";
        if ($latestSoil) {
            $sensorContext .= "- Tanah: Kelembapan {$latestSoil->kelembapan}%, Nitrogen {$latestSoil->nitrogen} mg/kg, Fosfor {$latestSoil->fosfor} mg/kg, Kalium {$latestSoil->kalium} mg/kg, pH {$latestSoil->ph}\n";
        }
        if ($latestWeather) {
            $sensorContext .= "- Lingkungan: Suhu {$latestWeather->suhu}°C, Curah Hujan {$latestWeather->curah_hujan} mm, Kecepatan Angin {$latestWeather->kecepatan_angin} m/s\n";
        }
        if ($latestWater) {
            $sensorContext .= "- Air: pH {$latestWater->ph}, Suhu {$latestWater->suhu}°C, TDS {$latestWater->tds} ppm\n";
        }
        $sensorContext .= "Gunakan data ini jika pengguna bertanya tentang kondisi lahan mereka.";

        $finalSystemPrompt = $ai_system_prompt . $sensorContext;

        if ($openRouterKey) {
            try {
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Bearer ' . $openRouterKey,
                    'HTTP-Referer' => url('/'),
                    'X-Title' => 'Agronex AI',
                ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $ai_model,
                    'max_tokens' => 1000,
                    'messages' => [
                        ['role' => 'system', 'content' => $finalSystemPrompt],
                        ['role' => 'user', 'content' => $message],
                    ],
                ]);

                if ($response->successful()) {
                    $reply = $response->json('choices.0.message.content');
                } else {
                    $reply = 'Maaf, terjadi kesalahan API (Error: ' . $response->status() . ' - ' . $response->body() . ').';
                }
            } catch (\Exception $e) {
                $reply = 'Maaf, gagal menghubungi server AI. Error lokal: ' . $e->getMessage();
            }
        } else {
            // Mock response
            $reply = 'Halo! Saya asisten AI denrawit x agronex. Saat ini Token belum dikonfigurasi. Untuk pertanyaan seputar "' . htmlspecialchars($message) . '", silakan minta Admin untuk mengonfigurasi API Key AI di halaman Admin Dashboard.';
        }

        return response()->json([
            'reply' => $reply
        ]);
    }
}
