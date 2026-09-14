<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceConfig;
use App\Models\IrrigationEvent;
use App\Models\IrrigationCommand;
use App\Models\SoilData;

class IrrigationApiController extends Controller
{
    // GET /api/v1/devices/{device_id}/config
    public function getConfig($device_id)
    {
        $device = Device::where('device_id', $device_id)->first();
        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        // Update last seen
        $device->update(['last_seen_at' => now(), 'status' => 'online']);

        $config = DeviceConfig::where('device_id', $device_id)->first();
        
        // Check for pending manual commands
        $command = IrrigationCommand::where('device_id', $device_id)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'asc')
            ->first();
            
        $cmdString = 'NONE';
        if ($command) {
            $cmdString = $command->command; // PUMP_ON or PUMP_OFF
            $command->update(['status' => 'EXECUTED']);
        }

        return response()->json([
            'status' => 'success',
            'config' => [
                'mode' => $config->mode ?? 'AUTO_SENSOR',
                'threshold_on' => $config->threshold_on ?? 35,
                'threshold_off' => $config->threshold_off ?? 50,
                'target_moisture' => $config->target_moisture ?? 60,
                'max_watering_duration' => $config->max_watering_duration ?? 300,
                'cooldown_minutes' => $config->cooldown_minutes ?? 10
            ],
            'command' => $cmdString
        ]);
    }

    // POST /api/v1/devices/{device_id}/telemetry
    public function postTelemetry(Request $request, $device_id)
    {
        $device = Device::where('device_id', $device_id)->first();
        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }
        
        $device->update(['last_seen_at' => now(), 'status' => 'online']);

        // Save telemetry data to SoilData (as per existing system)
        if ($request->has('soil_moisture')) {
            // we simulate inserting to soil data
            SoilData::create([
                'kelembapan' => $request->soil_moisture,
                'nitrogen' => rand(40, 60), // Mock other sensors if not provided
                'fosfor' => rand(30, 50),
                'kalium' => rand(30, 50),
                'ph' => rand(5.5, 7.5)
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    // POST /api/v1/devices/{device_id}/events
    public function postEvent(Request $request, $device_id)
    {
        $device = Device::where('device_id', $device_id)->first();
        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $device->update(['last_seen_at' => now(), 'status' => 'online']);

        IrrigationEvent::create([
            'device_id' => $device_id,
            'trigger_type' => $request->trigger_type ?? 'AUTO',
            'moisture_before' => $request->moisture_before,
            'moisture_after' => $request->moisture_after,
            'pump_started_at' => $request->pump_started_at ? date('Y-m-d H:i:s', strtotime($request->pump_started_at)) : now(),
            'pump_stopped_at' => $request->pump_stopped_at ? date('Y-m-d H:i:s', strtotime($request->pump_stopped_at)) : null,
            'duration_seconds' => $request->duration_seconds ?? 0,
            'status' => $request->status ?? 'completed'
        ]);

        return response()->json(['status' => 'success']);
    }
}
