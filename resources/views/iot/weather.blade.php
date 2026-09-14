@extends('layouts.mobile')

@section('title', 'Detail Cuaca & Lingkungan - denrawit x agronex')

@section('content')
<div class="px-4 py-6 bg-slate-50 min-h-screen">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Cuaca & Lingkungan</h2>
            <p class="text-slate-500 text-sm mt-1">Stasiun Iklim Mikro Lahan</p>
        </div>
        <a href="{{ route('iot.weather.download') }}" class="bg-white border border-slate-200 text-sky-600 px-3 py-2 rounded-lg shadow-sm text-sm font-semibold hover:bg-slate-50 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download CSV
        </a>
    </div>

    @if($latest)
        <div class="flex items-center justify-end mb-4">
            @php
                $isOffline = \Carbon\Carbon::parse($latest->created_at)->diffInMinutes(now()) > 60;
                $isSensorError = false;
                if($latest->suhu == 0 && $latest->kelembapan == 0) {
                    $isSensorError = true;
                }
            @endphp
            @if($isOffline)
                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Offline
                </span>
            @elseif($isSensorError)
                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span> Gangguan
                </span>
            @else
                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Berfungsi Baik
                </span>
            @endif
        </div>

        <div class="w-full h-40 bg-slate-200 rounded-xl overflow-hidden relative z-0" id="weatherMap"></div>
    </div>

    <!-- Peringatan Alat -->
    @if($isOffline || $isSensorError)
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div>
            <h4 class="font-bold text-red-800 text-sm">Peringatan Sistem</h4>
            <p class="text-xs text-red-600 mt-1">
                @if($isOffline)
                    Sistem cuaca terpantau <b>Offline</b>. Terakhir mengirim data pada {{ $latest->created_at->format('d/m/Y H:i') }}. Mohon periksa koneksi WiFi atau sumber daya (listrik/baterai) pada alat ESP32 Anda.
                @elseif($isSensorError)
                    Sistem mendeteksi <b>gangguan pembacaan sensor</b>. Nilai suhu dan kelembapan menunjukkan 0. Silakan periksa sambungan kabel sensor BME280 Anda.
                @endif
            </p>
        </div>
    </div>
    @endif

    <!-- Analisis Data Cuaca -->
    <div class="bg-gradient-to-br from-sky-50 to-indigo-50 rounded-2xl p-5 shadow-sm border border-sky-100 mb-6">
        <h3 class="font-bold text-sky-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.759-1.215 4.5 4.5 0 11-.867 8.195" />
            </svg>
            Keterangan Cuaca Lahan
        </h3>
        <div class="space-y-2 text-sm text-slate-700">
            @php
                $statusSuhu = 'Normal';
                if($latest->suhu > 34) {
                    $statusSuhu = 'Sangat Panas';
                } elseif($latest->suhu < 20) {
                    $statusSuhu = 'Dingin';
                }

                $statusKelembapan = 'Ideal';
                if($latest->kelembapan > 85) {
                    $statusKelembapan = 'Sangat Lembap (Rentan Jamur/Penyakit)';
                } elseif($latest->kelembapan < 40) {
                    $statusKelembapan = 'Kering (Tingkatkan Penyiraman)';
                }
            @endphp
            
            <p><strong>Suhu ({{ $latest->suhu }} °C):</strong> {{ $statusSuhu }}.</p>
            <p><strong>Kelembapan ({{ $latest->kelembapan }} %):</strong> {{ $statusKelembapan }}.</p>
            <p><strong>Curah Hujan ({{ $latest->curah_hujan }}):</strong> @if($latest->curah_hujan > 0) Terdeteksi curah hujan. @else Tidak ada hujan. @endif</p>
            <p><strong>Evapotranspirasi (ET0 - {{ $latest->et0 }} mm/d):</strong> Perkiraan hilangnya air dari tanaman ke udara. Nilai ini sangat berguna untuk menjadwalkan irigasi.</p>
        </div>
        <div class="mt-4 pt-3 border-t border-sky-200/50 text-[10px] text-sky-700/70 italic flex items-start gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p><strong>Catatan:</strong> Analisis ini adalah estimasi otomatis berdasarkan pembacaan stasiun iklim mini. Akurasinya tidak mutlak pasti, disarankan untuk tetap melakukan pengamatan fisik cuaca di lapangan.</p>
        </div>
    </div>

    <!-- Data Realtime Lengkap -->
    <h3 class="font-bold text-slate-800 mb-3">Data Sensor Saat Ini <span class="text-[10px] text-emerald-600 font-normal ml-2 flex items-center inline-flex gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Live</span></h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6" id="realtime-data-container">
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Suhu</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-suhu">{{ $latest->suhu }}</span><span class="text-xs text-slate-400 font-normal ml-1">°C</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Kelembapan</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-kelembapan">{{ $latest->kelembapan }}</span><span class="text-xs text-slate-400 font-normal ml-1">%</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Tekanan Udara</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-tekanan">{{ $latest->tekanan }}</span><span class="text-xs text-slate-400 font-normal ml-1">hPa</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Intensitas Cahaya</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-cahaya">{{ $latest->cahaya }}</span><span class="text-xs text-slate-400 font-normal ml-1">Lux</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Kecepatan Angin</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-kecepatan_angin">{{ $latest->kecepatan_angin }}</span><span class="text-xs text-slate-400 font-normal ml-1">m/s</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Curah Hujan</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-curah_hujan">{{ $latest->curah_hujan }}</span><span class="text-xs text-slate-400 font-normal ml-1">Pulse</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Dew Point</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-dew_point">{{ $latest->dew_point }}</span><span class="text-xs text-slate-400 font-normal ml-1">°C</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 transition-colors duration-300">
            <div class="text-xs text-slate-500 font-semibold mb-1">Evapotranspirasi</div>
            <div class="text-xl font-bold text-slate-800"><span id="rt-et0">{{ $latest->et0 }}</span><span class="text-xs text-slate-400 font-normal ml-1">mm/d</span></div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 mb-6 overflow-hidden">
        <h3 class="font-bold text-slate-800 mb-4">Grafik Suhu Lahan</h3>
        <div class="relative h-48 w-full">
            <canvas id="tempChart"></canvas>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Log Historis Cuaca</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Suhu (°C)</th>
                        <th class="px-4 py-3">Hum (%)</th>
                        <th class="px-4 py-3">Lux</th>
                        <th class="px-4 py-3">Angin (m/s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $row)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900 whitespace-nowrap">{{ $row->created_at->format('d/m H:i') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $row->suhu > 34 ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $row->suhu }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $row->kelembapan }}</td>
                        <td class="px-4 py-3">{{ $row->cahaya }}</td>
                        <td class="px-4 py-3">{{ $row->kecepatan_angin }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $history->links('pagination::tailwind') }}
        </div>
    </div>
    @else
    <div class="text-center py-10">
        <div class="text-slate-400 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
            </svg>
        </div>
        <p class="text-slate-500">Belum ada data cuaca yang diterima.</p>
    </div>
    @endif

</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($latest)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Initialization
    const ctx = document.getElementById('tempChart').getContext('2d');
    
    // Process data for Chart JS
    const rawData = @json($chartData);
    const labels = rawData.map(item => {
        const d = new Date(item.created_at);
        return d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');
    });
    const tempData = rawData.map(item => item.suhu);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Suhu Lahan (°C)',
                data: tempData,
                borderColor: '#0ea5e9', // sky-500
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#0ea5e9',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    min: 10,
                    max: 45,
                    ticks: { stepSize: 5 }
                }
            }
        }
    });
</script>

<script>
    // Realtime Data Polling
    setInterval(function() {
        fetch('/api/weather-data/latest')
            .then(response => response.json())
            .then(result => {
                if(result.success && result.data) {
                    const data = result.data;
                    
                    // Highlight effect helper
                    const updateWithHighlight = (id, newValue) => {
                        const el = document.getElementById(id);
                        if(el && el.innerText != newValue) {
                            el.innerText = newValue;
                            const card = el.closest('div.bg-white');
                            card.classList.add('bg-emerald-50');
                            setTimeout(() => card.classList.remove('bg-emerald-50'), 1000);
                        }
                    };

                    updateWithHighlight('rt-suhu', data.suhu);
                    updateWithHighlight('rt-kelembapan', data.kelembapan);
                    updateWithHighlight('rt-tekanan', data.tekanan);
                    updateWithHighlight('rt-cahaya', data.cahaya);
                    updateWithHighlight('rt-kecepatan_angin', data.kecepatan_angin);
                    updateWithHighlight('rt-curah_hujan', data.curah_hujan);
                    updateWithHighlight('rt-dew_point', data.dew_point);
                    updateWithHighlight('rt-et0', data.et0);
                }
            })
            .catch(error => console.error("Error fetching realtime data:", error));
    }, 5000); // Poll every 5 seconds
</script>
@endif
@endpush
@endsection
