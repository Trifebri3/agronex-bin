@extends('layouts.mobile')

@section('title', 'SoilSense - Kualitas Tanah')

@section('content')
<div class="px-4 py-6 bg-slate-50 min-h-screen">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-amber-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                SoilSense™
            </h2>
            <p class="text-slate-500 text-sm mt-1">Sistem Cerdas Agronomi Lahan</p>
        </div>
        <a href="{{ route('iot.soilsense.download') }}" class="bg-white border border-slate-200 text-amber-600 px-3 py-2 rounded-lg shadow-sm text-sm font-semibold hover:bg-slate-50 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download CSV
        </a>
    </div>

    @if($latest)
    @php
        // Algoritma Cerdas Agronomi Sederhana
        $isOffline = \Carbon\Carbon::parse($latest->created_at)->diffInMinutes(now()) > 15;
        
        // Status Tanah
        $statusN = $latest->nitrogen < 30 ? 'Kurang' : ($latest->nitrogen > 80 ? 'Lebih' : 'Optimal');
        $statusP = $latest->fosfor < 20 ? 'Kurang' : ($latest->fosfor > 60 ? 'Lebih' : 'Optimal');
        $statusK = $latest->kalium < 40 ? 'Kurang' : ($latest->kalium > 100 ? 'Lebih' : 'Optimal');
        $statuspH = $latest->ph < 6 ? 'Asam' : ($latest->ph > 7.5 ? 'Basa' : 'Netral');
        $statusMoisture = $latest->kelembapan < 40 ? 'Kering' : ($latest->kelembapan > 80 ? 'Terlalu Basah' : 'Ideal');
    @endphp



    <!-- Peringatan Alat -->
    @if($isOffline)
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6 flex items-start gap-3 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div>
            <h4 class="font-bold">Perangkat Offline</h4>
            <p class="text-sm">Tidak ada data baru sejak {{ \Carbon\Carbon::parse($latest->created_at)->diffForHumans() }}. Periksa daya dan koneksi internet pada ESP32.</p>
        </div>
    </div>
    @endif

    <!-- Diagnosis Cerdas -->
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-5 shadow-sm border border-amber-100 mb-6">
        <h3 class="font-bold text-amber-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            Analisis Asisten Agronomi
        </h3>
        <ul class="space-y-3 text-sm text-slate-700">
            @if($statusMoisture == 'Kering')
                <li class="flex gap-2"><span>-</span> <strong>Tanah Kering:</strong> Kelembapan hanya {{ $latest->kelembapan }}%. Segera lakukan penyiraman/irigasi.</li>
            @elseif($statusMoisture == 'Terlalu Basah')
                <li class="flex gap-2"><span>-</span> <strong>Terlalu Basah:</strong> Kelembapan {{ $latest->kelembapan }}%. Periksa sistem drainase agar akar tidak busuk.</li>
            @else
                <li class="flex gap-2"><span>-</span> <strong>Kelembapan Ideal:</strong> Kelembapan {{ $latest->kelembapan }}%. Kondisi sangat baik untuk pertumbuhan.</li>
            @endif

            @if($statuspH == 'Asam')
                <li class="flex gap-2"><span>-</span> <strong>Tanah Asam:</strong> pH {{ $latest->ph }}. Pertimbangkan untuk menaburkan Kapur Pertanian (Dolomit).</li>
            @elseif($statuspH == 'Basa')
                <li class="flex gap-2"><span>-</span> <strong>Tanah Basa:</strong> pH {{ $latest->ph }}. Bisa diturunkan dengan belerang atau bahan organik.</li>
            @else
                <li class="flex gap-2"><span>-</span> <strong>pH Netral:</strong> pH {{ $latest->ph }}. Sangat ideal untuk mayoritas tanaman.</li>
            @endif

            @if($statusN == 'Kurang' || $statusP == 'Kurang' || $statusK == 'Kurang')
                <li class="flex gap-2"><span>-</span> <strong>Kekurangan Nutrisi:</strong>
                    Tingkatkan pemupukan, terutama elemen: 
                    @if($statusN == 'Kurang') Nitrogen, @endif
                    @if($statusP == 'Kurang') Fosfor, @endif
                    @if($statusK == 'Kurang') Kalium. @endif
                </li>
            @else
                <li class="flex gap-2"><span>-</span> <strong>Nutrisi Makro (NPK):</strong> Kandungan pupuk NPK terpantau optimal.</li>
            @endif
        </ul>
        <div class="mt-4 pt-3 border-t border-amber-200/50 text-[10px] text-amber-700/70 italic flex items-start gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p><strong>Catatan:</strong> Analisis ini adalah estimasi otomatis berdasarkan pembacaan sensor. Akurasinya tidak mutlak pasti, disarankan untuk tetap melakukan pengamatan fisik di lapangan.</p>
        </div>
    </div>

    <!-- Parameter Detail (Grid) -->
    <h3 class="font-bold text-slate-800 mb-3">Tingkat Kesuburan Tanah (Terkini)</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        
        <!-- Suhu & Kelembapan -->
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 flex flex-col justify-between">
            <div class="text-xs text-slate-500 font-semibold mb-1">Kelembapan</div>
            <div class="text-2xl font-black text-blue-500">{{ $latest->kelembapan }}<span class="text-sm font-normal ml-1">%</span></div>
            <div class="text-[10px] text-slate-400 mt-2">{{ $statusMoisture }}</div>
        </div>
        
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 flex flex-col justify-between">
            <div class="text-xs text-slate-500 font-semibold mb-1">Suhu Tanah</div>
            <div class="text-2xl font-black text-amber-500">{{ $latest->suhu }}<span class="text-sm font-normal ml-1">°C</span></div>
            <div class="text-[10px] text-slate-400 mt-2">Termometer</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 flex flex-col justify-between">
            <div class="text-xs text-slate-500 font-semibold mb-1">pH Level</div>
            <div class="text-2xl font-black text-purple-500">{{ $latest->ph }}</div>
            <div class="text-[10px] text-slate-400 mt-2">Skala Keasaman</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 flex flex-col justify-between">
            <div class="text-xs text-slate-500 font-semibold mb-1">Konduktivitas (EC)</div>
            <div class="text-2xl font-black text-emerald-500">{{ $latest->ec }}<span class="text-sm font-normal ml-1">uS/cm</span></div>
            <div class="text-[10px] text-slate-400 mt-2">Kepadatan Ion</div>
        </div>

        <!-- NPK -->
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 col-span-2 md:col-span-1">
            <div class="text-xs text-slate-500 font-semibold mb-1">Nitrogen (N)</div>
            <div class="text-2xl font-black text-green-600">{{ $latest->nitrogen }}<span class="text-sm font-normal ml-1">mg/kg</span></div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ min(($latest->nitrogen / 150) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 col-span-2 md:col-span-1">
            <div class="text-xs text-slate-500 font-semibold mb-1">Fosfor (P)</div>
            <div class="text-2xl font-black text-orange-500">{{ $latest->fosfor }}<span class="text-sm font-normal ml-1">mg/kg</span></div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                <div class="bg-orange-400 h-1.5 rounded-full" style="width: {{ min(($latest->fosfor / 100) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 col-span-2 md:col-span-1">
            <div class="text-xs text-slate-500 font-semibold mb-1">Kalium (K)</div>
            <div class="text-2xl font-black text-red-500">{{ $latest->kalium }}<span class="text-sm font-normal ml-1">mg/kg</span></div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                <div class="bg-red-400 h-1.5 rounded-full" style="width: {{ min(($latest->kalium / 200) * 100, 100) }}%"></div>
            </div>
        </div>
    </div>

    <!-- Chart NPK Bar -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 mb-6">
        <h3 class="font-bold text-slate-800 mb-1">Komposisi Makronutrien NPK</h3>
        <p class="text-xs text-slate-500 mb-4">Perbandingan kadar Nitrogen, Fosfor, dan Kalium saat ini.</p>
        <div class="relative h-48 w-full">
            <canvas id="npkChart"></canvas>
        </div>
    </div>

    <!-- Chart Suhu & Kelembapan -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 mb-6">
        <h3 class="font-bold text-slate-800 mb-1">Tren Suhu & Kelembapan</h3>
        <p class="text-xs text-slate-500 mb-4">Riwayat fluktuasi kondisi fisik tanah.</p>
        <div class="relative h-48 w-full">
            <canvas id="soilEnvChart"></canvas>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Log Pengukuran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">N (mg)</th>
                        <th class="px-4 py-3">P (mg)</th>
                        <th class="px-4 py-3">K (mg)</th>
                        <th class="px-4 py-3">Moist (%)</th>
                        <th class="px-4 py-3">pH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $row)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900 whitespace-nowrap">{{ $row->created_at->format('d/m H:i') }}</td>
                        <td class="px-4 py-3">{{ $row->nitrogen }}</td>
                        <td class="px-4 py-3">{{ $row->fosfor }}</td>
                        <td class="px-4 py-3">{{ $row->kalium }}</td>
                        <td class="px-4 py-3">{{ $row->kelembapan }}</td>
                        <td class="px-4 py-3">{{ $row->ph }}</td>
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
    <!-- No Data -->
    <div class="text-center py-16 bg-white rounded-3xl shadow-sm border border-slate-100 mt-6">
        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Sensor Belum Aktif</h3>
        <p class="text-slate-500 max-w-xs mx-auto">Tancapkan sensor Soil NPK ke tanah dan pastikan ESP32 terhubung ke internet.</p>
    </div>
    @endif
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($latest)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Data
    const rawData = @json($chartData);
    const labels = rawData.map(item => {
        const d = new Date(item.created_at);
        return d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');
    });

    // 1. NPK Bar Chart (Hanya data terbaru)
    const npkCtx = document.getElementById('npkChart').getContext('2d');
    new Chart(npkCtx, {
        type: 'bar',
        data: {
            labels: ['Nitrogen (N)', 'Fosfor (P)', 'Kalium (K)'],
            datasets: [{
                label: 'Kadar (mg/kg)',
                data: [{{ $latest->nitrogen }}, {{ $latest->fosfor }}, {{ $latest->kalium }}],
                backgroundColor: [
                    'rgba(22, 163, 74, 0.8)', // green-600
                    'rgba(249, 115, 22, 0.8)', // orange-500
                    'rgba(239, 68, 68, 0.8)'   // red-500
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // 2. Soil Environment Line Chart
    const envCtx = document.getElementById('soilEnvChart').getContext('2d');
    const moistData = rawData.map(item => item.kelembapan);
    const tempData = rawData.map(item => item.suhu);

    new Chart(envCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Kelembapan (%)',
                    data: moistData,
                    borderColor: '#3b82f6', // blue-500
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    pointRadius: 2,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Suhu (°C)',
                    data: tempData,
                    borderColor: '#f59e0b', // amber-500
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointRadius: 2,
                    fill: false,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
            },
            scales: { y: { beginAtZero: false } }
        }
    });
</script>
@endif
@endpush
@endsection
