@extends('layouts.mobile')

@section('title', 'Hasil Analisis LAB - denrawit x agronex')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('lab.index') }}" class="p-2 bg-white rounded-full shadow-sm text-slate-500 hover:text-emerald-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold">Hasil <span class="text-emerald-500">Analisis</span></h2>
        <div class="w-9"></div> <!-- Spacer for center alignment -->
    </div>

    <!-- Summary Box -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative mb-6">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-xl mb-1">Status Lahan</h4>
                    <p class="text-slate-300 text-sm">Berdasarkan tindakan pada {{ $plantType }}</p>
                </div>
                @if($status == 'BAIK')
                    <div class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> AMAN
                    </div>
                @elseif($status == 'PERHATIAN')
                    <div class="bg-amber-500/20 border border-amber-500/30 text-amber-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span> PERHATIAN
                    </div>
                @else
                    <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span> BERBAHAYA
                    </div>
                @endif
            </div>
            
            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/10 flex gap-2 flex-wrap">
                @foreach($actionsDone as $act)
                    <span class="bg-white/20 text-white text-[10px] px-2 py-1 rounded-md font-medium uppercase tracking-wider">
                        {{ str_replace('_', ' ', $act) }}
                    </span>
                @endforeach
            </div>
        </div>
        
        <!-- Decorations -->
        @php $decoColor = $status == 'BAIK' ? 'emerald' : ($status == 'PERHATIAN' ? 'amber' : 'red'); @endphp
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-{{ $decoColor }}-500/20 rounded-full blur-3xl"></div>
    </div>

    <!-- IoT Data Snapshot -->
    <div class="mb-6">
        <h3 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wider">Kondisi Saat Ini</h3>
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium">Kelembapan</div>
                    <div class="font-bold text-slate-800">{{ $latestSoil ? $latestSoil->kelembapan.'%' : '-' }}</div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 font-medium">Nitrogen</div>
                    <div class="font-bold text-slate-800">{{ $latestSoil ? $latestSoil->nitrogen.' mg' : '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    <div>
        <h3 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wider">Rekomendasi Pintar</h3>
        <div class="space-y-4">
            @foreach($recommendations as $rec)
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 w-1 h-full @if(strpos(strtolower($rec['title']), 'resiko') !== false || strpos(strtolower($rec['title']), 'berlebih') !== false) bg-red-500 @elseif(strpos(strtolower($rec['title']), 'offline') !== false || strpos(strtolower($rec['title']), 'peringatan') !== false) bg-amber-500 @else bg-emerald-500 @endif"></div>
                    <h4 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        @if(strpos(strtolower($rec['title']), 'resiko') !== false || strpos(strtolower($rec['title']), 'berlebih') !== false || strpos(strtolower($rec['title']), 'basah') !== false)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        @elseif(strpos(strtolower($rec['title']), 'offline') !== false || strpos(strtolower($rec['title']), 'peringatan') !== false)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @endif
                        {{ $rec['title'] }}
                    </h4>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $rec['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Simulasi AR Link -->
    @if($plantType == 'Cabai')
    <div class="mt-8 text-center">
        <a href="{{ route('ar.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
            Simulasi AR Pertumbuhan Cabai
        </a>
    </div>
    @endif

</div>
@endsection
