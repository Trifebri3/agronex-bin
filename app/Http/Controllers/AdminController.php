<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Setting;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        // Gunakan password statis untuk backdoor
        if ($request->password === 'admin123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Password salah!');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Polygon
        $polygon_coords = Setting::where('key', 'polygon_coords')->value('value') ?? '[]';
        
        // Marker coordinates and metadata
        $soil_lat = Setting::where('key', 'soil_lat')->value('value') ?? '-6.914744';
        $soil_lng = Setting::where('key', 'soil_lng')->value('value') ?? '107.609810';
        $soil_photo = Setting::where('key', 'soil_photo')->value('value') ?? '';
        $soil_desc = Setting::where('key', 'soil_desc')->value('value') ?? '';

        $weather_lat = Setting::where('key', 'weather_lat')->value('value') ?? '-6.914500';
        $weather_lng = Setting::where('key', 'weather_lng')->value('value') ?? '107.609500';
        $weather_photo = Setting::where('key', 'weather_photo')->value('value') ?? '';
        $weather_desc = Setting::where('key', 'weather_desc')->value('value') ?? '';

        $water_lat = Setting::where('key', 'water_lat')->value('value') ?? '-6.915000';
        $water_lng = Setting::where('key', 'water_lng')->value('value') ?? '107.610000';
        $water_photo = Setting::where('key', 'water_photo')->value('value') ?? '';
        $water_desc = Setting::where('key', 'water_desc')->value('value') ?? '';

        $terranir_lat = Setting::where('key', 'terranir_lat')->value('value') ?? '-6.914200';
        $terranir_lng = Setting::where('key', 'terranir_lng')->value('value') ?? '107.610500';
        $terranir_photo = Setting::where('key', 'terranir_photo')->value('value') ?? '';
        $terranir_desc = Setting::where('key', 'terranir_desc')->value('value') ?? '';

        $kawasan_desc = Setting::where('key', 'kawasan_desc')->value('value') ?? 'Lahan Pertanian Agronex';
        $kawasan_photo = Setting::where('key', 'kawasan_photo')->value('value') ?? '';

        $farm_name = Setting::where('key', 'farm_name')->value('value') ?? 'Sawah Cisewu';
        $crop_type = Setting::where('key', 'crop_type')->value('value') ?? 'Padi';
        $farm_area = Setting::where('key', 'farm_area')->value('value') ?? '0,8';

        // AI Settings
        $ai_api_key = '';
        $encrypted_key = Setting::where('key', 'ai_api_key')->value('value');
        if ($encrypted_key) {
            try {
                $ai_api_key = Crypt::decryptString($encrypted_key);
            } catch (\Exception $e) {
                $ai_api_key = '';
            }
        }
        $ai_system_prompt = Setting::where('key', 'ai_system_prompt')->value('value') ?? 'Kamu adalah asisten AI ahli pertanian bernama Agronex AI. Jawab dalam bahasa Indonesia, ramah, dan ringkas.';
        $ai_model = Setting::where('key', 'ai_model')->value('value') ?? 'google/gemini-2.5-flash';

        return view('admin.dashboard', compact(
            'polygon_coords', 
            'soil_lat', 'soil_lng', 'soil_photo', 'soil_desc',
            'weather_lat', 'weather_lng', 'weather_photo', 'weather_desc',
            'water_lat', 'water_lng', 'water_photo', 'water_desc',
            'terranir_lat', 'terranir_lng', 'terranir_photo', 'terranir_desc',
            'kawasan_desc', 'kawasan_photo',
            'farm_name', 'crop_type', 'farm_area',
            'ai_api_key', 'ai_system_prompt', 'ai_model'
        ));
    }

    public function updateSettings(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Save Polygon JSON & Process Base64 Photos
        if ($request->has('polygon_coords')) {
            $polygonJson = $request->polygon_coords;
            $points = json_decode($polygonJson, true);
            
            if (is_array($points)) {
                $baseDir = public_path('uploads/polygon_points');
                if (!file_exists($baseDir)) {
                    mkdir($baseDir, 0777, true);
                }

                foreach ($points as $index => &$pt) {
                    if (isset($pt['photo']) && str_starts_with($pt['photo'], 'data:image')) {
                        // Extract base64
                        list($type, $data) = explode(';', $pt['photo']);
                        list(, $data)      = explode(',', $data);
                        $data = base64_decode($data);
                        
                        $filename = 'point_' . time() . '_' . $index . '.jpg';
                        file_put_contents($baseDir . '/' . $filename, $data);
                        
                        // Replace base64 with file path
                        $pt['photo'] = 'uploads/polygon_points/' . $filename;
                    }
                }
                
                $polygonJson = json_encode($points);
            }

            Setting::updateOrCreate(['key' => 'polygon_coords'], ['value' => $polygonJson]);
        }

        // Save markers and their metadata
        $markers = ['soil', 'weather', 'water', 'terranir'];
        foreach ($markers as $m) {
            if ($request->has($m.'_lat') && $request->has($m.'_lng')) {
                Setting::updateOrCreate(['key' => $m.'_lat'], ['value' => $request->input($m.'_lat')]);
                Setting::updateOrCreate(['key' => $m.'_lng'], ['value' => $request->input($m.'_lng')]);
            }
            if ($request->has($m.'_desc')) {
                Setting::updateOrCreate(['key' => $m.'_desc'], ['value' => $request->input($m.'_desc')]);
            }
            if ($request->hasFile($m.'_photo')) {
                $file = $request->file($m.'_photo');
                $filename = time() . '_' . $m . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                Setting::updateOrCreate(['key' => $m.'_photo'], ['value' => 'uploads/' . $filename]);
            }
        }

        // Save Text Description
        if ($request->has('kawasan_desc')) {
            Setting::updateOrCreate(['key' => 'kawasan_desc'], ['value' => $request->kawasan_desc]);
        }

        // Save Farm details
        if ($request->has('farm_name')) {
            Setting::updateOrCreate(['key' => 'farm_name'], ['value' => $request->farm_name]);
        }
        if ($request->has('crop_type')) {
            Setting::updateOrCreate(['key' => 'crop_type'], ['value' => $request->crop_type]);
        }
        if ($request->has('farm_area')) {
            Setting::updateOrCreate(['key' => 'farm_area'], ['value' => $request->farm_area]);
        }

        // Save AI Settings
        if ($request->has('ai_api_key') && !empty($request->ai_api_key)) {
            Setting::updateOrCreate(['key' => 'ai_api_key'], ['value' => Crypt::encryptString($request->ai_api_key)]);
        }
        if ($request->has('ai_system_prompt')) {
            Setting::updateOrCreate(['key' => 'ai_system_prompt'], ['value' => $request->ai_system_prompt]);
        }
        if ($request->has('ai_model')) {
            Setting::updateOrCreate(['key' => 'ai_model'], ['value' => $request->ai_model]);
        }

        // Handle Photo Upload directly to public/uploads
        if ($request->hasFile('kawasan_photo')) {
            $file = $request->file('kawasan_photo');
            $filename = time() . '_kawasan_' . $file->getClientOriginalName();
            
            // Move to public/uploads
            $file->move(public_path('uploads'), $filename);
            
            Setting::updateOrCreate(['key' => 'kawasan_photo'], ['value' => 'uploads/' . $filename]);
        }

        return back()->with('success', 'Konfigurasi kawasan dan peta berhasil diperbarui!');
    }
}
