<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceConfig;
use App\Models\IrrigationEvent;
use App\Models\IrrigationCommand;

class AutomationController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        // Since we are simulating, create a mock device if empty
        if ($devices->isEmpty()) {
            $device = Device::create([
                'device_id' => 'AGR-001',
                'name' => 'ESP32 Penyiram Lahan',
                'location' => 'Lahan Cisewu A',
                'status' => 'online',
                'last_seen_at' => now()
            ]);
            DeviceConfig::create([
                'device_id' => 'AGR-001',
                'mode' => 'AUTO_SENSOR',
                'threshold_on' => 35,
                'threshold_off' => 50,
                'target_moisture' => 60
            ]);
            $devices = Device::all();
        }

        $configs = DeviceConfig::all()->keyBy('device_id');
        $events = IrrigationEvent::orderBy('created_at', 'desc')->take(10)->get();

        return view('automation.index', compact('devices', 'configs', 'events'));
    }

    public function updateConfig(Request $request)
    {
        $config = DeviceConfig::where('device_id', $request->device_id)->first();
        if ($config) {
            $config->update($request->only([
                'mode', 'threshold_on', 'threshold_off', 'target_moisture', 'max_watering_duration', 'cooldown_minutes'
            ]));
        }
        return back()->with('success', 'Konfigurasi alat berhasil diperbarui.');
    }

    public function sendCommand(Request $request)
    {
        IrrigationCommand::create([
            'device_id' => $request->device_id,
            'command' => $request->command,
            'status' => 'PENDING'
        ]);

        return back()->with('success', 'Perintah manual (' . $request->command . ') dikirim ke alat.');
    }
}
