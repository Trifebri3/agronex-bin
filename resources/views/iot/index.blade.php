@extends('layouts.mobile')

@section('title', 'Data IoT - denrawit x agronex')

@section('content')
<div class="px-4 py-6">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Kondisi <span class="text-blue-500">Lahan</span></h2>
        <p class="text-slate-500 mt-1">Pantau sensor lahan Anda secara real-time.</p>
    </div>

    <!-- Peta Global -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 mb-6">
        <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
            </svg>
            Peta & Lokasi Kawasan
        </h3>
        
        @if($kawasan_photo)
            <div class="mb-4 rounded-xl overflow-hidden shadow-sm">
                <img src="{{ asset($kawasan_photo) }}" alt="Foto Kawasan" class="w-full h-40 object-cover">
            </div>
        @endif

        <div class="w-full h-64 bg-slate-200 rounded-xl overflow-hidden relative z-0 border border-slate-200" id="globalMap"></div>
        
        @if($kawasan_desc)
            <div class="mt-4 p-3 bg-slate-50 rounded-lg text-sm text-slate-700 border border-slate-100">
                <strong>Keterangan:</strong><br>
                {{ $kawasan_desc }}
            </div>
        @endif
    </div>

    <!-- Kesimpulan Analisis Global -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <h3 class="font-bold text-lg text-slate-800">Analisis Lahan Hari Ini</h3>
            @if($statusGlobal == 'BAIK')
                <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full font-bold">BAIK</span>
            @elseif($statusGlobal == 'PERHATIAN')
                <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full font-bold">PERHATIAN</span>
            @else
                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-bold animate-pulse">TINDAKAN</span>
            @endif
        </div>
        
        <p class="text-sm text-slate-600 mb-4">{{ $globalMessage }}</p>

        @if(count($issues) > 0)
            <div class="space-y-3">
                @foreach($issues as $issue)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 border-l-4 @if($issue['type'] == 'water') border-l-blue-500 @elseif($issue['type'] == 'fertilizer') border-l-green-500 @elseif($issue['type'] == 'weather') border-l-amber-500 @else border-l-red-500 @endif">
                    <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $issue['title'] }}</h4>
                    <p class="text-xs text-slate-600 mb-2"><strong>Kenapa:</strong> {{ $issue['desc'] }}</p>
                    <div class="flex flex-col sm:flex-row gap-2 sm:items-center justify-between">
                        <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Tindakan: {{ $issue['action'] }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-bold bg-white px-2 py-1 rounded-lg border border-slate-200">
                            {{ $issue['time'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <p class="text-[10px] text-slate-400 mt-3 italic">*Catatan: Akurasi prediksi bergantung pada kalibrasi sensor dan kondisi lapangan. Harap validasi kembali secara visual.</p>
        @endif
    </div>

    <!-- IoT Sensors List -->
    <div class="space-y-4">
        @foreach($sensors as $sensor)
        
        @if($sensor['type'] == 'water')
            <a href="{{ route('iot.water.detail') }}" class="block">
        @elseif($sensor['type'] == 'weather')
            <a href="{{ route('iot.weather.detail') }}" class="block">
        @elseif($sensor['type'] == 'soil')
            <a href="{{ route('iot.soilsense.detail') }}" class="block">
        @elseif($sensor['type'] == 'terranir')
            <a href="{{ route('iot.terranir.detail') }}" class="block">
        @endif

        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-{{ $sensor['color'] }}-50 text-{{ $sensor['color'] }}-500 flex items-center justify-center">
                    @if($sensor['type'] == 'soil')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif($sensor['type'] == 'weather')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                    @elseif($sensor['type'] == 'water')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    @elseif($sensor['type'] == 'terranir')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">{{ $sensor['name'] }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 rounded-full bg-{{ $sensor['color'] }}-500 animate-pulse"></span>
                        <span class="text-xs text-slate-500 font-medium">Realtime</span>
                    </div>
                </div>
            </div>
            
            <div class="text-right flex items-center gap-3">
                <div>
                    <div class="text-xl font-bold text-slate-800">{{ $sensor['value'] }}</div>
                    @php
                        // Determine color dynamically
                        $scolor = 'slate';
                        if ($sensor['condition'] == 'Normal' || $sensor['condition'] == 'Baik') $scolor = 'emerald';
                        elseif ($sensor['condition'] == 'Panas' || $sensor['condition'] == 'Kering' || $sensor['condition'] == 'Perhatian') $scolor = 'orange';
                    @endphp
                    <div class="text-xs font-semibold text-{{ $scolor }}-600 mt-1 bg-{{ $scolor }}-50 px-2 py-0.5 rounded text-center inline-block">
                        {{ $sensor['condition'] }}
                    </div>
                </div>
                @if($sensor['type'] == 'water' || $sensor['type'] == 'weather' || $sensor['type'] == 'soil' || $sensor['type'] == 'terranir')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </div>

        @if($sensor['type'] == 'water' || $sensor['type'] == 'weather' || $sensor['type'] == 'soil' || $sensor['type'] == 'terranir')
            </a>
        @endif
        @endforeach
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl p-4 text-sm text-blue-800 flex gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        <p>Data diambil langsung dari sensor di lahan Anda dan diperbarui setiap menit.</p>
    </div>

</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Leaflet Map Initialization
    const centerLat = {{ $soil_lat }};
    const centerLng = {{ $soil_lng }};
    const map = L.map('globalMap').setView([centerLat, centerLng], 16);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Render Polygon with Photo Popups
    let polygonCoords = [];
    try {
        polygonCoords = {!! $polygon_coords ?: '[]' !!};
    } catch (e) {}

    if (polygonCoords.length > 0) {
        const latlngs = polygonCoords.map(p => [p.lat, p.lng]);
        
        // Draw Polygon
        L.polygon(latlngs, {
            color: '#10b981', 
            fillColor: '#10b981', 
            fillOpacity: 0.2
        }).addTo(map);

        // Draw Vertex Markers with Photo Popups
        polygonCoords.forEach((p, i) => {
            const mk = L.circleMarker([p.lat, p.lng], {
                radius: 6,
                fillColor: "#ffffff",
                color: "#059669",
                weight: 2,
                opacity: 1,
                fillOpacity: 1
            }).addTo(map);

            let imgSrc = p.photo;
            if(imgSrc && !imgSrc.startsWith('data:')) {
                imgSrc = '/' + imgSrc; 
            }
            
            let popupContent = `
                <div style="text-align:center; min-width: 150px;">
                    <div style="font-weight:bold; margin-bottom:5px;">Sudut Lahan ${i+1}</div>
                    ${imgSrc ? `<img src="${imgSrc}" style="width:100%; border-radius:8px; margin-bottom:5px;">` : `<div style="font-size:10px; color:#999;">Tidak ada foto</div>`}
                </div>
            `;
            
            mk.bindPopup(popupContent);
        });
        
        // Adjust zoom to fit polygon
        const bounds = L.latLngBounds(latlngs);
        map.fitBounds(bounds, {padding: [20,20]});
    }

    // Render Sensor Markers
    const markersData = [
        { 
            lat: {{ $soil_lat }}, lng: {{ $soil_lng }}, color: 'green', title: 'SoilSense', 
            photo: '{{ $soil_photo }}', desc: `{{ addslashes($soil_desc) }}` 
        },
        { 
            lat: {{ $weather_lat }}, lng: {{ $weather_lng }}, color: 'orange', title: 'EnviroSense',
            photo: '{{ $weather_photo }}', desc: `{{ addslashes($weather_desc) }}` 
        },
        { 
            lat: {{ $water_lat }}, lng: {{ $water_lng }}, color: 'blue', title: 'WaterSense',
            photo: '{{ $water_photo }}', desc: `{{ addslashes($water_desc) }}` 
        },
        { 
            lat: {{ $terranir_lat }}, lng: {{ $terranir_lng }}, color: 'violet', title: 'TerraNIR',
            photo: '{{ $terranir_photo }}', desc: `{{ addslashes($terranir_desc) }}` 
        },
    ];

    markersData.forEach(m => {
        const iconHtml = `<div style="background-color:${m.color}; width:24px; height:24px; border-radius:50%; border:3px solid white; box-shadow:0 0 5px rgba(0,0,0,0.5); display:flex; align-items:center; justify-content:center;"></div>`;
        const customIcon = L.divIcon({ html: iconHtml, className: '', iconSize: [24, 24], iconAnchor: [12, 12] });

        let imgSrc = m.photo ? '/' + m.photo : '';
        let popupContent = `
            <div style="text-align:center; min-width: 150px; padding: 5px;">
                <div style="font-weight:bold; margin-bottom:8px; font-size:14px; color:${m.color};">${m.title}</div>
                ${imgSrc ? `<img src="${imgSrc}" style="width:100%; border-radius:8px; margin-bottom:8px;">` : ''}
                ${m.desc ? `<div style="font-size:12px; color:#333; text-align:left;">${m.desc}</div>` : ''}
                ${!imgSrc && !m.desc ? `<div style="font-size:11px; color:#999;">Tidak ada detail</div>` : ''}
            </div>
        `;

        L.marker([m.lat, m.lng], { icon: customIcon })
            .addTo(map)
            .bindTooltip(m.title, {permanent: false, direction: 'top', offset: [0, -12]})
            .bindPopup(popupContent);
    });
</script>
@endpush
@endsection
