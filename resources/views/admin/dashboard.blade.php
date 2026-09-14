<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Pemetaan Kawasan</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-10">
    <nav class="bg-slate-900 text-white p-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="font-bold flex items-center gap-2">
            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            Admin Panel
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.index') }}" class="text-slate-300 hover:text-white text-sm font-medium">Lihat Aplikasi</a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-1.5 rounded-lg text-sm font-semibold transition-colors shadow">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Konfigurasi Kawasan & Peta</h1>
            <p class="text-slate-500 mt-1">Gambarkan poligon lahan Anda dan posisikan fitur sensor di peta.</p>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Map Section -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    Pemetaan Kawasan & Sensor (Geo-Tracking)
                </h2>
                
                <div class="flex flex-wrap gap-3 mb-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="w-full mb-2">
                        <p class="text-sm font-semibold text-slate-700">Lacak Poligon Lahan:</p>
                        <p class="text-xs text-slate-500">Berjalanlah ke ujung lahan, lalu tekan "Ambil via GPS" dan foto kondisi fisik di titik tersebut.</p>
                    </div>
                    <button type="button" id="btnGpsPoint" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Ambil via GPS
                    </button>
                    <button type="button" id="btnManualPoint" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                        Titik Manual (Klik Peta)
                    </button>
                    <button type="button" id="btnClearPolygon" class="bg-red-50 border border-red-200 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-100 transition-colors ml-auto">
                        Hapus Poligon
                    </button>
                    
                    <div class="w-full text-xs text-indigo-600 font-semibold mt-2" id="gpsStatus">Status: Siap melacak.</div>
                </div>

                <!-- Hidden file input for capturing photo -->
                <input type="file" id="pointPhotoInput" accept="image/*" capture="environment" class="hidden">

                <div class="grid lg:grid-cols-3 gap-6 mb-6">
                    <!-- Map Container -->
                    <div class="lg:col-span-2 w-full h-96 bg-slate-200 rounded-2xl overflow-hidden border border-slate-200 z-0" id="adminMap"></div>
                    
                    <!-- Points List -->
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-4 max-h-96 overflow-y-auto">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 border-b border-slate-200 pb-2">Daftar Titik Lahan</h3>
                        <div id="pointsList" class="space-y-3">
                            <p class="text-xs text-slate-400 italic" id="emptyPointsText">Belum ada titik. Mulai ambil titik untuk menggambar keliling lahan.</p>
                        </div>
                    </div>
                </div>
                
                <p class="text-sm text-slate-500 mb-4">Geser marker (pin) untuk menyesuaikan lokasi akurat dari keempat fitur ini.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Hidden input to store JSON points -->
                    <input type="hidden" name="polygon_coords" id="polygonCoordsInput" value="{{ $polygon_coords }}">
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="font-bold text-sm text-emerald-700 mb-2 flex justify-between items-center">
                            SoilSense
                            <button type="button" onclick="getSensorGps('soil')" class="bg-emerald-100 text-emerald-700 p-1 rounded hover:bg-emerald-200" title="Ambil GPS">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                        <input type="text" name="soil_lat" id="soilLat" value="{{ $soil_lat }}" class="w-full text-xs p-2 mb-2 border rounded bg-white" readonly>
                        <input type="text" name="soil_lng" id="soilLng" value="{{ $soil_lng }}" class="w-full text-xs p-2 mb-3 border rounded bg-white" readonly>
                        <textarea name="soil_desc" placeholder="Deskripsi/Catatan..." class="w-full text-xs p-2 mb-2 border rounded bg-white resize-none" rows="2">{{ $soil_desc ?? '' }}</textarea>
                        @if($soil_photo) <img src="{{ asset($soil_photo) }}" class="w-full h-16 object-cover rounded mb-2"> @endif
                        <input type="file" name="soil_photo" accept="image/*" class="w-full text-[10px]">
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="font-bold text-sm text-orange-600 mb-2 flex justify-between items-center">
                            EnviroSense
                            <button type="button" onclick="getSensorGps('weather')" class="bg-orange-100 text-orange-700 p-1 rounded hover:bg-orange-200" title="Ambil GPS">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                        <input type="text" name="weather_lat" id="weatherLat" value="{{ $weather_lat }}" class="w-full text-xs p-2 mb-2 border rounded bg-white" readonly>
                        <input type="text" name="weather_lng" id="weatherLng" value="{{ $weather_lng }}" class="w-full text-xs p-2 mb-3 border rounded bg-white" readonly>
                        <textarea name="weather_desc" placeholder="Deskripsi/Catatan..." class="w-full text-xs p-2 mb-2 border rounded bg-white resize-none" rows="2">{{ $weather_desc ?? '' }}</textarea>
                        @if($weather_photo) <img src="{{ asset($weather_photo) }}" class="w-full h-16 object-cover rounded mb-2"> @endif
                        <input type="file" name="weather_photo" accept="image/*" class="w-full text-[10px]">
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="font-bold text-sm text-blue-600 mb-2 flex justify-between items-center">
                            WaterSense
                            <button type="button" onclick="getSensorGps('water')" class="bg-blue-100 text-blue-700 p-1 rounded hover:bg-blue-200" title="Ambil GPS">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                        <input type="text" name="water_lat" id="waterLat" value="{{ $water_lat }}" class="w-full text-xs p-2 mb-2 border rounded bg-white" readonly>
                        <input type="text" name="water_lng" id="waterLng" value="{{ $water_lng }}" class="w-full text-xs p-2 mb-3 border rounded bg-white" readonly>
                        <textarea name="water_desc" placeholder="Deskripsi/Catatan..." class="w-full text-xs p-2 mb-2 border rounded bg-white resize-none" rows="2">{{ $water_desc ?? '' }}</textarea>
                        @if($water_photo) <img src="{{ asset($water_photo) }}" class="w-full h-16 object-cover rounded mb-2"> @endif
                        <input type="file" name="water_photo" accept="image/*" class="w-full text-[10px]">
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="font-bold text-sm text-purple-600 mb-2 flex justify-between items-center">
                            TerraNIR
                            <button type="button" onclick="getSensorGps('terranir')" class="bg-purple-100 text-purple-700 p-1 rounded hover:bg-purple-200" title="Ambil GPS">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                        <input type="text" name="terranir_lat" id="terranirLat" value="{{ $terranir_lat }}" class="w-full text-xs p-2 mb-2 border rounded bg-white" readonly>
                        <input type="text" name="terranir_lng" id="terranirLng" value="{{ $terranir_lng }}" class="w-full text-xs p-2 mb-3 border rounded bg-white" readonly>
                        <textarea name="terranir_desc" placeholder="Deskripsi/Catatan..." class="w-full text-xs p-2 mb-2 border rounded bg-white resize-none" rows="2">{{ $terranir_desc ?? '' }}</textarea>
                        @if($terranir_photo) <img src="{{ asset($terranir_photo) }}" class="w-full h-16 object-cover rounded mb-2"> @endif
                        <input type="file" name="terranir_photo" accept="image/*" class="w-full text-[10px]">
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Tambahan</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Kawasan Global</label>
                        @if($kawasan_photo)
                            <div class="mb-3">
                                <img src="{{ asset($kawasan_photo) }}" alt="Foto Kawasan" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif
                        <input type="file" name="kawasan_photo" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                        <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
                    </div>
                    
                    <div>
                        <h3 class="font-bold text-slate-800 mb-4">Profil Lahan</h3>
                        <div class="mb-4 space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lahan</label>
                                <input type="text" name="farm_name" value="{{ $farm_name }}" placeholder="Contoh: Sawah Cisewu" class="w-full text-sm p-2 border rounded-lg bg-slate-50">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Tanaman</label>
                                    <input type="text" name="crop_type" value="{{ $crop_type }}" placeholder="Contoh: Padi" class="w-full text-sm p-2 border rounded-lg bg-slate-50">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Luas Lahan (Ha)</label>
                                    <input type="number" step="0.01" name="farm_area" value="{{ $farm_area }}" placeholder="Contoh: 0.8" class="w-full text-sm p-2 border rounded-lg bg-slate-50">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Kawasan Lahan (Global)</label>
                                <textarea name="kawasan_desc" rows="3" class="w-full text-sm p-2 border rounded-lg bg-slate-50">{{ $kawasan_desc ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Settings -->
                <div class="mt-8">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Konfigurasi AI (Enkripsi)
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">OpenRouter API Key (Di-enkripsi dalam Database)</label>
                            <input type="password" name="ai_api_key" placeholder="{{ $ai_api_key ? '******** (Sudah Terisi)' : 'sk-or-v1-...' }}" class="w-full text-sm p-2 border rounded-lg bg-slate-50">
                            <p class="text-[10px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah key yang sudah ada.</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Model AI</label>
                            <input type="text" name="ai_model" value="{{ $ai_model }}" class="w-full text-sm p-2 border rounded-lg bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">System Prompt</label>
                            <textarea name="ai_system_prompt" rows="3" class="w-full text-sm p-2 border rounded-lg bg-slate-50">{{ $ai_system_prompt }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-10 rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
                    Simpan Semua Konfigurasi
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Init Map
        const centerLat = {{ $soil_lat }};
        const centerLng = {{ $soil_lng }};
        const map = L.map('adminMap').setView([centerLat, centerLng], 16);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // --- POLYGON LOGIC ---
        // polygonCoords format: [{lat: -6.9, lng: 107.6, photo: 'base64...' or 'path...'}]
        let polygonCoords = [];
        try {
            polygonCoords = {!! $polygon_coords ?: '[]' !!};
        } catch (e) { polygonCoords = []; }

        let polygonLayer = null;
        let vertexMarkers = [];
        let isManualMode = false;
        
        const polygonInput = document.getElementById('polygonCoordsInput');
        const statusText = document.getElementById('gpsStatus');
        const photoInput = document.getElementById('pointPhotoInput');
        const pointsList = document.getElementById('pointsList');
        const emptyPointsText = document.getElementById('emptyPointsText');
        
        let pendingTempLocation = null;

        function renderPointsList() {
            if (polygonCoords.length === 0) {
                emptyPointsText.style.display = 'block';
                pointsList.innerHTML = '';
                pointsList.appendChild(emptyPointsText);
            } else {
                emptyPointsText.style.display = 'none';
                pointsList.innerHTML = '';
                polygonCoords.forEach((pt, index) => {
                    const item = document.createElement('div');
                    item.className = 'flex items-center gap-3 bg-white p-2 border border-slate-100 rounded-lg shadow-sm';
                    
                    let imgSrc = pt.photo;
                    if(imgSrc && !imgSrc.startsWith('data:')) {
                        imgSrc = '/' + imgSrc; // prepending slash for public paths
                    }
                    if(!imgSrc) imgSrc = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23cbd5e1"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';

                    item.innerHTML = `
                        <img src="${imgSrc}" class="w-10 h-10 object-cover rounded bg-slate-100">
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold text-slate-800">Titik ${index + 1}</div>
                            <div class="text-[10px] text-slate-500 truncate">${pt.lat.toFixed(5)}, ${pt.lng.toFixed(5)}</div>
                        </div>
                    `;
                    pointsList.appendChild(item);
                });
            }
        }

        function drawPolygon() {
            if (polygonLayer) map.removeLayer(polygonLayer);
            vertexMarkers.forEach(m => map.removeLayer(m));
            vertexMarkers = [];

            if (polygonCoords.length > 0) {
                const latlngs = polygonCoords.map(p => [p.lat, p.lng]);
                
                // Draw polygon
                polygonLayer = L.polygon(latlngs, {
                    color: '#10b981', 
                    fillColor: '#10b981', 
                    fillOpacity: 0.2
                }).addTo(map);

                // Draw vertex markers
                polygonCoords.forEach((p, i) => {
                    const mk = L.circleMarker([p.lat, p.lng], {
                        radius: 5,
                        fillColor: "#ffffff",
                        color: "#059669",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 1
                    }).addTo(map).bindTooltip("Titik " + (i+1));
                    vertexMarkers.push(mk);
                });
            }
            
            polygonInput.value = JSON.stringify(polygonCoords);
            renderPointsList();
        }

        drawPolygon();

        // 1. GPS Button Click
        document.getElementById('btnGpsPoint').addEventListener('click', function() {
            if ("geolocation" in navigator) {
                statusText.innerText = "Mencari sinyal GPS...";
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    statusText.innerText = "GPS Akurat. Silakan ambil foto titik ini!";
                    map.panTo([lat, lng]);
                    
                    // Save temp location and trigger camera
                    pendingTempLocation = { lat, lng };
                    photoInput.click();

                }, function(error) {
                    statusText.innerText = "Gagal mendapatkan GPS. Coba gunakan titik manual.";
                    statusText.classList.replace('text-indigo-600', 'text-red-600');
                }, { enableHighAccuracy: true, timeout: 10000 });
            } else {
                alert("Geolokasi tidak didukung di peramban ini.");
            }
        });

        // 2. Manual Point Mode Toggle
        const btnManual = document.getElementById('btnManualPoint');
        btnManual.addEventListener('click', function() {
            isManualMode = !isManualMode;
            if(isManualMode) {
                btnManual.classList.replace('bg-white', 'bg-slate-200');
                statusText.innerText = "Mode Manual: Klik lokasi di peta.";
                document.getElementById('adminMap').style.cursor = 'crosshair';
            } else {
                btnManual.classList.replace('bg-slate-200', 'bg-white');
                statusText.innerText = "Mode Manual dibatalkan.";
                document.getElementById('adminMap').style.cursor = 'grab';
            }
        });

        // 3. Map Click for Manual Mode
        map.on('click', function(e) {
            if (isManualMode) {
                pendingTempLocation = { lat: e.latlng.lat, lng: e.latlng.lng };
                statusText.innerText = "Titik manual dipilih. Silakan ambil foto!";
                isManualMode = false;
                btnManual.classList.replace('bg-slate-200', 'bg-white');
                document.getElementById('adminMap').style.cursor = 'grab';
                
                photoInput.click();
            }
        });

        // 4. Photo Capture Handler
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && pendingTempLocation) {
                // Convert photo to base64
                const reader = new FileReader();
                reader.onload = function(event) {
                    const base64Photo = event.target.result;
                    
                    // Add point to array
                    polygonCoords.push({
                        lat: pendingTempLocation.lat,
                        lng: pendingTempLocation.lng,
                        photo: base64Photo
                    });
                    
                    statusText.innerText = "Titik berhasil ditambahkan!";
                    drawPolygon();
                    pendingTempLocation = null;
                    photoInput.value = ''; // Reset
                };
                reader.readAsDataURL(file);
            }
        });

        // 5. Clear Polygon
        document.getElementById('btnClearPolygon').addEventListener('click', function() {
            if(confirm('Hapus semua titik poligon?')) {
                polygonCoords = [];
                drawPolygon();
                statusText.innerText = "Poligon dihapus.";
            }
        });

        // --- SENSOR MARKERS LOGIC ---
        const markersData = [
            { id: 'soil', lat: {{ $soil_lat }}, lng: {{ $soil_lng }}, color: 'green', title: 'SoilSense' },
            { id: 'weather', lat: {{ $weather_lat }}, lng: {{ $weather_lng }}, color: 'orange', title: 'EnviroSense' },
            { id: 'water', lat: {{ $water_lat }}, lng: {{ $water_lng }}, color: 'blue', title: 'WaterSense' },
            { id: 'terranir', lat: {{ $terranir_lat }}, lng: {{ $terranir_lng }}, color: 'violet', title: 'TerraNIR' },
        ];
        
        let sensorMapMarkers = {};

        markersData.forEach(m => {
            const iconHtml = `<div style="background-color:${m.color}; width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow:0 0 5px rgba(0,0,0,0.5);"></div>`;
            const customIcon = L.divIcon({ html: iconHtml, className: '', iconSize: [20, 20], iconAnchor: [10, 10] });

            const mk = L.marker([m.lat, m.lng], {
                icon: customIcon,
                draggable: true,
                title: m.title
            }).addTo(map).bindTooltip(m.title, {permanent: true, direction: 'top', offset: [0, -10]});

            mk.on('dragend', function(e) {
                const pos = mk.getLatLng();
                document.getElementById(m.id + 'Lat').value = pos.lat.toFixed(6);
                document.getElementById(m.id + 'Lng').value = pos.lng.toFixed(6);
            });
            
            sensorMapMarkers[m.id] = mk;
        });

        function getSensorGps(sensorId) {
            if ("geolocation" in navigator) {
                const oldText = statusText.innerText;
                statusText.innerText = `Mengambil GPS untuk ${sensorId}...`;
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    document.getElementById(sensorId + 'Lat').value = lat.toFixed(6);
                    document.getElementById(sensorId + 'Lng').value = lng.toFixed(6);
                    
                    if (sensorMapMarkers[sensorId]) {
                        sensorMapMarkers[sensorId].setLatLng([lat, lng]);
                        map.panTo([lat, lng]);
                    }
                    
                    statusText.innerText = "GPS berhasil diambil!";
                    setTimeout(() => statusText.innerText = oldText, 3000);
                }, function(error) {
                    alert("Gagal mendapatkan GPS. Pastikan izin lokasi aktif.");
                    statusText.innerText = oldText;
                }, { enableHighAccuracy: true, timeout: 10000 });
            } else {
                alert("Geolokasi tidak didukung.");
            }
        }
    </script>
</body>
</html>
