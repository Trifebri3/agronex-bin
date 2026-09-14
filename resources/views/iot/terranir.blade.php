@extends('layouts.mobile')

@section('title', 'TerraNIR - Coming Soon')

@section('content')
<div class="px-4 py-6 bg-slate-50 min-h-screen">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-purple-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                TerraNIR™
            </h2>
            <p class="text-slate-500 text-sm mt-1">Pemindai Klorofil & Daun (NIR)</p>
        </div>
    </div>

    <!-- Coming Soon Banner -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-3xl p-6 shadow-md text-white text-center mb-8 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10">
            <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest inline-block mb-3 border border-white/30 backdrop-blur-sm">
                Coming Soon
            </span>
            <h3 class="text-3xl font-black mb-2">Segera Hadir</h3>
            <p class="text-purple-100 text-sm">Teknologi pemindaian daun menggunakan <i>Near-Infrared Reflectance</i> untuk mengetahui kadar Nitrogen pada daun tanaman tanpa merusak (non-destructive).</p>
        </div>
    </div>

    <!-- Fitur Gambaran -->
    <h3 class="font-bold text-slate-800 mb-4">Gambaran Fitur yang Akan Hadir:</h3>
    <div class="space-y-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex gap-4 items-start">
            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Scan Klorofil Daun</h4>
                <p class="text-sm text-slate-500 mt-1">Gunakan perangkat sensor portabel atau kamera khusus untuk memindai daun dan langsung mengetahui kadar hijau daun (klorofil) secara instan.</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex gap-4 items-start">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Kalkulasi Pemupukan Daun</h4>
                <p class="text-sm text-slate-500 mt-1">Sistem akan secara otomatis menyarankan takaran pupuk daun (*foliar spray*) yang tepat berdasarkan defisiensi nitrogen yang terdeteksi.</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex gap-4 items-start">
            <div class="w-12 h-12 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Analisis Spektral AI</h4>
                <p class="text-sm text-slate-500 mt-1">Didukung oleh algoritma Machine Learning yang dapat membedakan daun sehat dengan daun yang terserang penyakit sejak dini (sebelum terlihat oleh mata telanjang).</p>
            </div>
        </div>
    </div>
</div>
@endsection
