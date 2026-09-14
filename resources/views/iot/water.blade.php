@extends('layouts.mobile')

@section('title', 'Detail Kualitas Air - denrawit x agronex')

@section('content')
<div class="px-4 py-6 bg-slate-50 min-h-screen">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Kualitas Air</h2>
            <p class="text-slate-500 text-sm mt-1">Riwayat Sensor Kolam/Lahan</p>
        </div>
        <a href="{{ route('iot.water.download') }}" class="bg-white border border-slate-200 text-emerald-600 px-3 py-2 rounded-lg shadow-sm text-sm font-semibold hover:bg-slate-50 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download CSV
        </a>
    </div>

    @if($latest)


    <!-- Analisis Data -->
    <div class="bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl p-5 shadow-sm border border-emerald-100 mb-6">
        <h3 class="font-bold text-emerald-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            Keterangan Kualitas Air Saat Ini
        </h3>
        <div class="space-y-2 text-sm text-slate-700">
            @php
                $statusPh = 'Normal';
                $saranPh = 'Kondisi air optimal untuk tanaman/ikan.';
                
                if($latest->ph < 6.5) {
                    $statusPh = 'Terlalu Asam';
                    $saranPh = 'Air terlalu asam (pH '.$latest->ph.'). Tambahkan kapur dolomit untuk menaikkan pH secara perlahan.';
                } elseif($latest->ph > 8.5) {
                    $statusPh = 'Terlalu Basa';
                    $saranPh = 'Air terlalu basa (pH '.$latest->ph.'). Anda bisa menambahkan bahan organik seperti daun ketapang untuk menurunkannya.';
                }

                $statusTds = 'Normal';
                if($latest->tds > 1000) {
                    $statusTds = 'Tinggi';
                }

                $statusTurbidity = 'Jernih';
                if($latest->turbidity > 50) {
                    $statusTurbidity = 'Keruh';
                }
            @endphp
            
            <p><strong>pH ({{ $latest->ph }}):</strong> {{ $statusPh }}. {{ $saranPh }}</p>
            <p><strong>TDS ({{ $latest->tds }} ppm):</strong> Tergolong {{ $statusTds }}. Ini menunjukkan tingkat kepekatan zat terlarut dalam air.</p>
            <p><strong>Kekeruhan ({{ $latest->turbidity }} NTU):</strong> Air terlihat {{ $statusTurbidity }}. @if($latest->turbidity > 50) Sebaiknya periksa sistem filter atau sirkulasi air Anda. @endif</p>
            <p><strong>Suhu ({{ $latest->suhu }} °C):</strong> @if($latest->suhu > 32) Terlalu panas, perhatikan peneduh. @elseif($latest->suhu < 20) Terlalu dingin. @else Normal. @endif</p>
        </div>
        <div class="mt-4 pt-3 border-t border-emerald-200/50 text-[10px] text-emerald-700/70 italic flex items-start gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p><strong>Catatan:</strong> Analisis ini adalah estimasi otomatis berdasarkan pembacaan sensor air. Akurasinya tidak mutlak pasti, disarankan untuk tetap melakukan pengamatan fisik air di kolam/lahan.</p>
        </div>
    </div>

    <!-- Data Realtime Lengkap -->
    <h3 class="font-bold text-slate-800 mb-3">Data Sensor Saat Ini</h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100">
            <div class="text-xs text-slate-500 font-semibold mb-1">pH Air</div>
            <div class="text-xl font-bold text-slate-800">{{ $latest->ph }}</div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100">
            <div class="text-xs text-slate-500 font-semibold mb-1">Suhu Air</div>
            <div class="text-xl font-bold text-slate-800">{{ $latest->suhu }}<span class="text-xs text-slate-400 font-normal ml-1">°C</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100">
            <div class="text-xs text-slate-500 font-semibold mb-1">TDS (Zat Terlarut)</div>
            <div class="text-xl font-bold text-slate-800">{{ $latest->tds }}<span class="text-xs text-slate-400 font-normal ml-1">ppm</span></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100">
            <div class="text-xs text-slate-500 font-semibold mb-1">Kekeruhan (Turbidity)</div>
            <div class="text-xl font-bold text-slate-800">{{ $latest->turbidity }}<span class="text-xs text-slate-400 font-normal ml-1">NTU</span></div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 mb-6 overflow-hidden">
        <h3 class="font-bold text-slate-800 mb-4">Grafik pH Air</h3>
        <div class="relative h-48 w-full">
            <canvas id="phChart"></canvas>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Log Historis</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Suhu (°C)</th>
                        <th class="px-4 py-3">pH</th>
                        <th class="px-4 py-3">TDS (ppm)</th>
                        <th class="px-4 py-3">Turb. (NTU)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $row)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900 whitespace-nowrap">{{ $row->created_at->format('d/m H:i') }}</td>
                        <td class="px-4 py-3">{{ $row->suhu }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $row->ph >= 6.5 && $row->ph <= 8.5 ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $row->ph }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $row->tds }}</td>
                        <td class="px-4 py-3">{{ $row->turbidity }}</td>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        </div>
        <p class="text-slate-500">Belum ada data sensor yang diterima.</p>
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
    const ctx = document.getElementById('phChart').getContext('2d');
    
    // Process data for Chart JS
    const rawData = @json($chartData);
    const labels = rawData.map(item => {
        const d = new Date(item.created_at);
        return d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');
    });
    const phData = rawData.map(item => item.ph);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'pH Air',
                data: phData,
                borderColor: '#10b981', // emerald-500
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#10b981',
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
                    min: 0,
                    max: 14,
                    ticks: { stepSize: 2 }
                }
            }
        }
    });
</script>
@endif
@endpush
@endsection
