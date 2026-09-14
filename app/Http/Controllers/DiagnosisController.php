<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        return view('diagnosis.index');
    }

    public function analyze(Request $request)
    {
        $geminiKey = config('services.gemini.key');
        $image = $request->file('image');

        if ($geminiKey && $image) {
            try {
                $base64Image = base64_encode(file_get_contents($image->getPathname()));
                $mimeType = $image->getMimeType();

                $response = \Illuminate\Support\Facades\Http::withoutVerifying()->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key=' . $geminiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Analisis gambar tanaman ini. Apakah ada penyakit? Berikan nama penyakit singkat (atau "Sehat"), tingkat keyakinan (0-100), dan rekomendasi singkat. Format JSON: {"disease": "...", "confidence": 90, "recommendation": "..."}'],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data' => $base64Image
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $resultText = $response->json('candidates.0.content.parts.0.text');
                    // Clean up markdown code block if gemini returns it
                    $resultText = str_replace(['```json', '```'], '', $resultText);
                    $resultData = json_decode(trim($resultText), true);

                    $disease = $resultData['disease'] ?? 'Tidak diketahui';
                    $confidence = $resultData['confidence'] ?? 0;
                    $recommendation = $resultData['recommendation'] ?? 'Gagal memproses rekomendasi.';
                } else {
                    $disease = 'Gagal (Error API)';
                    $confidence = 0;
                    $recommendation = 'Terjadi kesalahan saat menghubungi server Gemini.';
                }
            } catch (\Exception $e) {
                $disease = 'Error Sistem';
                $confidence = 0;
                $recommendation = 'Gagal memproses gambar: ' . $e->getMessage();
            }
        } else {
            // Mock response if no key or no image
            $disease = 'Bercak Daun (Simulasi - Token Belum Diset)';
            $confidence = 85;
            $recommendation = 'Silakan isi GEMINI_API_KEY di .env untuk hasil nyata.';
        }
        
        return response()->json([
            'status' => 'success',
            'disease' => $disease,
            'confidence' => $confidence,
            'recommendation' => $recommendation
        ]);
    }
}
