@extends('layouts.mobile')

@section('title', 'Simulasi AR Cabai - denrawit x agronex')

@section('content')
<!-- Import Model-Viewer -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>

<div class="px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ url()->previous() }}" class="p-2 bg-white rounded-full shadow-sm text-slate-500 hover:text-emerald-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold">Simulasi <span class="text-indigo-500">AR</span></h2>
        <div class="w-9"></div>
    </div>

    <!-- AR Container -->
    <div class="bg-white rounded-3xl p-4 shadow-sm border border-slate-100 relative mb-6">
        <div class="w-full h-[50vh] bg-slate-100 rounded-2xl overflow-hidden relative">
            
            <!-- We use a placeholder 3D model. -->
            <model-viewer 
                id="plantModel"
                src="https://modelviewer.dev/shared-assets/models/Astronaut.glb" 
                ios-src="https://modelviewer.dev/shared-assets/models/Astronaut.usdz"
                alt="3D Model Tanaman Cabai"
                ar 
                ar-modes="webxr scene-viewer quick-look" 
                camera-controls 
                auto-rotate
                shadow-intensity="1"
                class="w-full h-full transition-all duration-700 ease-in-out"
                style="--poster-color: transparent; filter: hue-rotate(0deg);">
                
                <div class="absolute bottom-4 left-0 right-0 flex justify-center z-10">
                    <button slot="ar-button" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:bg-indigo-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>
                        Tampilkan AR di Lahan
                    </button>
                </div>

            </model-viewer>

        </div>
        
        <!-- Kondisi Saat Ini -->
        <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
            <h4 class="font-bold text-slate-800 mb-2 text-sm">Kondisi Lahan Saat Ini</h4>
            <div class="flex flex-wrap gap-2 text-xs font-medium">
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md">Air: <span id="currentMoisture">{{ $latestSoil ? $latestSoil->kelembapan : 50 }}</span>%</span>
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md">N: <span id="currentNitrogen">{{ $latestSoil ? $latestSoil->nitrogen : 40 }}</span> mg</span>
                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-md">P: <span id="currentPhosphorus">{{ $latestSoil ? $latestSoil->fosfor : 30 }}</span> mg</span>
                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md">K: <span id="currentPotassium">{{ $latestSoil ? $latestSoil->kalium : 30 }}</span> mg</span>
                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-md">Suhu: <span id="currentTemp">{{ $latestWeather ? $latestWeather->suhu : 28 }}</span>°C</span>
            </div>
        </div>

        <!-- Input Simulasi -->
        <div class="mt-4 p-4 bg-white rounded-xl border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-800 mb-3 text-sm">Simulasikan Tindakan Anda</h4>
            
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Pupuk NPK (Gram/m²)</label>
                    <input type="number" id="inputNpk" placeholder="0" class="w-full p-2 text-sm border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Pupuk Urea (Gram/m²)</label>
                    <input type="number" id="inputUrea" placeholder="0" class="w-full p-2 text-sm border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Air Siraman (Liter/m²)</label>
                    <input type="number" id="inputWater" placeholder="0" class="w-full p-2 text-sm border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Pestisida (ml/m²)</label>
                    <input type="number" id="inputPesticide" placeholder="0" class="w-full p-2 text-sm border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>

            <button type="button" onclick="simulateReaction()" class="w-full bg-emerald-500 text-white font-bold py-3 rounded-lg hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/30">
                Jalankan Simulasi
            </button>
            
            <div id="reactionResult" class="mt-4 hidden p-3 rounded-lg text-sm font-semibold border"></div>
        </div>

        <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 text-sm text-indigo-800">
            <h4 class="font-bold mb-1 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Cara Penggunaan
            </h4>
            <ul class="list-disc pl-5 space-y-1">
                <li>Gunakan sentuhan untuk memutar (rotasi) dan mencubit untuk memperbesar (zoom).</li>
                <li>Klik tombol <strong>"Tampilkan AR di Lahan"</strong> untuk memunculkan objek 3D di dunia nyata (Hanya di perangkat yang didukung AR).</li>
                <li class="italic mt-2 text-indigo-600/70 text-xs">*Catatan: Model yang ditampilkan saat ini adalah placeholder (Contoh Astronaut). Anda dapat menggantinya dengan model .glb Cabai nanti.*</li>
            </ul>
        </div>
    </div>
</div>

<script>
    function simulateReaction() {
        const model = document.getElementById('plantModel');
        const reactionBox = document.getElementById('reactionResult');
        
        // Parse inputs (default 0 if empty)
        const npk = parseFloat(document.getElementById('inputNpk').value) || 0;
        const urea = parseFloat(document.getElementById('inputUrea').value) || 0;
        const water = parseFloat(document.getElementById('inputWater').value) || 0;
        const pesticide = parseFloat(document.getElementById('inputPesticide').value) || 0;
        
        // Parse current sensors
        let cN = parseFloat(document.getElementById('currentNitrogen').innerText);
        let cP = parseFloat(document.getElementById('currentPhosphorus').innerText);
        let cK = parseFloat(document.getElementById('currentPotassium').innerText);
        let cM = parseFloat(document.getElementById('currentMoisture').innerText);
        let cT = parseFloat(document.getElementById('currentTemp').innerText);
        
        // Calculate theoretical final conditions
        // NPK 15-15-15 roughly adds 1.5mg/kg per gram to each. Urea adds 4.6mg/kg N per gram.
        let fN = cN + (npk * 1.5) + (urea * 4.6);
        let fP = cP + (npk * 1.5);
        let fK = cK + (npk * 1.5);
        let fM = cM + (water * 4); // 1L adds 4% moisture roughly
        
        let status = 'normal';
        let msg = 'Tindakan selesai disimulasikan. Pertumbuhan berjalan normal.';
        let colorClass = 'bg-slate-50 border-slate-200 text-slate-700';
        
        // Visual effects defaults
        let newScale = '1 1 1';
        let newFilter = 'hue-rotate(0deg) saturate(1)';

        // Logic Evaluation
        if (pesticide > 15) {
            msg = 'Kacau! Dosis pestisida terlalu tinggi, tanaman keracunan kimia.';
            colorClass = 'bg-red-50 border-red-200 text-red-700';
            newScale = '0.85 0.85 0.85';
            newFilter = 'sepia(1) hue-rotate(270deg) saturate(0.2)'; // purple/dead
        } else if (fN > 150) {
            msg = 'Overdosis Pupuk! Kadar Nitrogen melonjak ('+Math.round(fN)+' mg). Daun "terbakar" (Plasmolisis) karena salinitas tinggi.';
            colorClass = 'bg-red-50 border-red-200 text-red-700';
            newScale = '0.9 0.9 0.9';
            newFilter = 'sepia(1) hue-rotate(340deg) saturate(3)'; // burnt
        } else if (fM > 95) {
            msg = 'Tanah Kebanjiran! (Kelembapan '+Math.round(fM)+'%). Akar akan kekurangan oksigen dan cepat busuk.';
            colorClass = 'bg-amber-50 border-amber-200 text-amber-700';
            newScale = '0.95 0.95 0.95';
            newFilter = 'hue-rotate(60deg) saturate(0.4)'; // pale
        } else if (fM < 30 && cT > 33) {
            msg = 'Tanaman Kepanasan & Kekeringan. Stres air tinggi membuat tanaman layu.';
            colorClass = 'bg-orange-50 border-orange-200 text-orange-700';
            newScale = '0.9 0.8 0.9';
            newFilter = 'sepia(0.8) hue-rotate(-20deg)'; // dry
        } else if (fN >= 70 && fN <= 120 && fM >= 60 && fM <= 85) {
            msg = 'Kondisi SUPER OPTIMAL! Kombinasi hara dan air sangat seimbang, panen maksimal.';
            colorClass = 'bg-emerald-50 border-emerald-200 text-emerald-700';
            newScale = '1.25 1.25 1.25';
            newFilter = 'saturate(2) hue-rotate(10deg)'; // very vibrant green
        } else if (npk === 0 && urea === 0 && water === 0 && pesticide === 0) {
            msg = 'Tidak ada tindakan yang dilakukan. Menggunakan kondisi asal.';
            colorClass = 'bg-blue-50 border-blue-200 text-blue-700';
        } else {
            msg = 'Kondisi cukup baik. Nutrisi tambahan diserap dengan wajar.';
            colorClass = 'bg-blue-50 border-blue-200 text-blue-700';
            newScale = '1.05 1.05 1.05';
        }

        // Apply visual scale properly to model-viewer
        model.setAttribute('scale', newScale);
        model.style.filter = newFilter;

        // Display results
        reactionBox.className = `mt-4 p-4 rounded-xl text-sm border ${colorClass} animate-fade-in transition-all`;
        reactionBox.innerHTML = `
            <div class="font-bold mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Hasil Simulasi
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs mb-3 p-2 bg-white/50 rounded-lg">
                <div>💧 Kelembapan Akhir: <strong>${Math.round(fM)}%</strong></div>
                <div>🌿 N Akhir: <strong>${Math.round(fN)} mg</strong></div>
                <div>🍂 P Akhir: <strong>${Math.round(fP)} mg</strong></div>
                <div>🥔 K Akhir: <strong>${Math.round(fK)} mg</strong></div>
            </div>
            <p class="leading-relaxed font-semibold">${msg}</p>
        `;
        reactionBox.classList.remove('hidden');
    }
</script>
@endsection
