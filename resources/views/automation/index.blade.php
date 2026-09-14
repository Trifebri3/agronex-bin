@extends('layouts.mobile')

@section('title', 'Smart Irrigation - denrawit x agronex')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Smart <span class="text-blue-500">Irrigation</span> 💧</h2>
        <p class="text-slate-500 mt-1">Otomasi dan kontrol penyiraman lahan cerdas.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-3 rounded-xl text-sm font-semibold mb-4 border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    @foreach($devices as $device)
    @php
        $config = $configs[$device->device_id] ?? (object)[
            'mode' => 'AUTO_SENSOR',
            'threshold_on' => 35,
            'threshold_off' => 50,
            'target_moisture' => 60,
            'max_watering_duration' => 300
        ];
    @endphp
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-bold text-lg text-slate-800 uppercase">{{ $device->location }}</h3>
                <p class="text-xs text-slate-500 font-medium">Device: {{ $device->device_id }}</p>
            </div>
            <div class="flex items-center gap-1">
                @if($device->status == 'online')
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-emerald-600">ONLINE</span>
                @else
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span class="text-xs font-bold text-slate-400">OFFLINE</span>
                @endif
            </div>
        </div>

        <!-- Mode Display -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex justify-between items-center mb-5">
            <div>
                <p class="text-[10px] text-blue-500 font-bold uppercase tracking-wider">Mode Aktif</p>
                <p class="font-bold text-blue-800 text-sm">
                    @if($config->mode == 'AUTO_SENSOR') AUTO (Batas Sensor) @endif
                    @if($config->mode == 'AUTO_TARGET') AUTO (Target Kelembapan) @endif
                    @if($config->mode == 'MANUAL') MANUAL KONTROL @endif
                </p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
        </div>

        <!-- Manual Control -->
        <h4 class="font-bold text-slate-700 text-sm mb-2">Kontrol Manual</h4>
        <div class="grid grid-cols-2 gap-3 mb-6">
            <form action="{{ route('automation.command') }}" method="POST">
                @csrf
                <input type="hidden" name="device_id" value="{{ $device->device_id }}">
                <input type="hidden" name="command" value="PUMP_ON">
                <button type="submit" class="w-full bg-slate-100 text-emerald-600 border border-emerald-200 font-bold py-3 rounded-xl hover:bg-emerald-50 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" /></svg>
                    PUMP ON
                </button>
            </form>
            <form action="{{ route('automation.command') }}" method="POST">
                @csrf
                <input type="hidden" name="device_id" value="{{ $device->device_id }}">
                <input type="hidden" name="command" value="PUMP_OFF">
                <button type="submit" class="w-full bg-slate-100 text-red-500 border border-red-200 font-bold py-3 rounded-xl hover:bg-red-50 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd" /></svg>
                    PUMP OFF
                </button>
            </form>
        </div>

        <!-- Configuration Form -->
        <h4 class="font-bold text-slate-700 text-sm mb-3">Konfigurasi Otomasi</h4>
        <form action="{{ route('automation.config') }}" method="POST" class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-4">
            @csrf
            <input type="hidden" name="device_id" value="{{ $device->device_id }}">
            
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Mode Irigasi</label>
                <select name="mode" id="modeSelect_{{ $device->device_id }}" class="w-full p-2 text-sm border border-slate-200 rounded-lg focus:ring-blue-500" onchange="toggleConfigFields('{{ $device->device_id }}')">
                    <option value="AUTO_SENSOR" {{ $config->mode == 'AUTO_SENSOR' ? 'selected' : '' }}>Otomatis (Berdasarkan Batas Sensor)</option>
                    <option value="AUTO_TARGET" {{ $config->mode == 'AUTO_TARGET' ? 'selected' : '' }}>Otomatis (Jaga Target Kelembapan)</option>
                    <option value="MANUAL" {{ $config->mode == 'MANUAL' ? 'selected' : '' }}>Manual Saja</option>
                </select>
                <p id="modeDesc_{{ $device->device_id }}" class="text-[10px] text-slate-500 mt-1 italic"></p>
            </div>

            <!-- Group: Auto Sensor -->
            <div id="groupSensor_{{ $device->device_id }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-3 rounded-lg border border-slate-200 hidden">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Bawah (%) <span class="text-emerald-500">→ Pompa NYALA</span></label>
                    <input type="number" name="threshold_on" value="{{ $config->threshold_on }}" class="w-full p-2 text-sm border border-slate-200 rounded-lg">
                    <p class="text-[9px] text-slate-400 mt-1">Pompa menyala saat tanah lebih kering dari angka ini.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Atas (%) <span class="text-red-500">→ Pompa MATI</span></label>
                    <input type="number" name="threshold_off" value="{{ $config->threshold_off }}" class="w-full p-2 text-sm border border-slate-200 rounded-lg">
                    <p class="text-[9px] text-slate-400 mt-1">Pompa berhenti saat tanah sudah mencapai kelembapan ini.</p>
                </div>
            </div>

            <!-- Group: Auto Target -->
            <div id="groupTarget_{{ $device->device_id }}" class="bg-white p-3 rounded-lg border border-slate-200 hidden">
                <label class="block text-xs font-bold text-slate-700 mb-1">Target Kelembapan (%)</label>
                <input type="number" name="target_moisture" value="{{ $config->target_moisture }}" class="w-full p-2 text-sm border border-slate-200 rounded-lg">
                <p class="text-[9px] text-slate-400 mt-1">Sistem akan berusaha menjaga kelembapan tanah di sekitar angka ini.</p>
            </div>

            <!-- Keamanan -->
            <div class="bg-red-50/50 p-3 rounded-lg border border-red-100">
                <label class="block text-xs font-bold text-slate-700 mb-1">Keamanan: Batas Maksimal Menyala (Detik)</label>
                <input type="number" name="max_watering_duration" value="{{ $config->max_watering_duration }}" class="w-full p-2 text-sm border border-slate-200 rounded-lg">
                <p class="text-[9px] text-slate-500 mt-1">Mencegah lahan kebanjiran jika sensor rusak. Pompa otomatis mati setelah durasi ini tercapai (Contoh: 300 detik = 5 menit).</p>
            </div>

            <button type="submit" class="w-full bg-slate-800 text-white font-bold py-2.5 rounded-lg hover:bg-slate-900 transition-colors text-sm">
                Simpan Konfigurasi
            </button>
        </form>
    </div>
    @endforeach

    <!-- Event History -->
    <div class="mb-20">
        <h3 class="font-bold text-slate-800 mb-4 px-1">Riwayat Penyiraman</h3>
        @if($events->isEmpty())
            <p class="text-sm text-slate-500 italic px-1">Belum ada riwayat penyiraman.</p>
        @else
            <div class="space-y-3">
                @foreach($events as $event)
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm font-bold text-slate-800">
                            @if($event->trigger_type == 'MANUAL')
                                <span class="text-orange-500">MANUAL</span>
                            @else
                                <span class="text-emerald-500">AUTO</span>
                            @endif
                            Trigger
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">Kelembapan: {{ $event->moisture_before }}% → {{ $event->moisture_after }}%</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($event->created_at)->format('d M Y H:i:s') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-md">{{ $event->duration_seconds }} detik</span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleConfigFields(deviceId) {
        const mode = document.getElementById('modeSelect_' + deviceId).value;
        const groupSensor = document.getElementById('groupSensor_' + deviceId);
        const groupTarget = document.getElementById('groupTarget_' + deviceId);
        const modeDesc = document.getElementById('modeDesc_' + deviceId);

        // Hide all first
        groupSensor.style.display = 'none';
        groupTarget.style.display = 'none';

        if (mode === 'AUTO_SENSOR') {
            groupSensor.style.display = 'grid';
            modeDesc.innerText = "Pompa menyala saat tanah kering dan mati saat tanah basah (dua batas).";
        } else if (mode === 'AUTO_TARGET') {
            groupTarget.style.display = 'block';
            modeDesc.innerText = "Sistem otomatis menjaga kelembapan stabil di angka target.";
        } else {
            modeDesc.innerText = "Otomatisasi mati. Anda mengontrol pompa secara manual sepenuhnya.";
        }
    }

    // Initialize on load
    document.addEventListener("DOMContentLoaded", function() {
        @foreach($devices as $device)
            toggleConfigFields('{{ $device->device_id }}');
        @endforeach
    });
</script>
@endpush
