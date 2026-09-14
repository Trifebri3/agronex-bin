@extends('layouts.mobile')

@section('title', 'Laboratorium Agronomi - denrawit x agronex')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6 flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold">Laboratorium <span class="text-emerald-500">Pintar</span></h2>
            <p class="text-slate-500 mt-1">Cek tindakan agronomi Anda dengan data sensor cerdas.</p>
        </div>
        <!-- Link to AR Simulation -->
        <a href="{{ route('ar.index') }}" class="bg-gradient-to-r from-emerald-500 to-teal-400 text-white p-2 rounded-xl shadow-lg shadow-emerald-500/30 flex items-center justify-center animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
        </a>
    </div>

    <!-- IoT Sensors Snapshot -->
    <div class="mb-6">
        <h3 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wider flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Kondisi Lahan Saat Ini
        </h3>
        <div class="space-y-3">
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

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-{{ $sensor['color'] }}-50 text-{{ $sensor['color'] }}-500 flex items-center justify-center">
                        @if($sensor['type'] == 'soil')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @elseif($sensor['type'] == 'weather')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                        @elseif($sensor['type'] == 'water')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        @elseif($sensor['type'] == 'terranir')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $sensor['name'] }}</h3>
                        <div class="flex items-center gap-1 mt-0.5">
                            <span class="text-[10px] text-slate-500 font-medium">Realtime</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-right flex items-center gap-2">
                    <div>
                        <div class="text-sm font-bold text-slate-800">{{ $sensor['value'] }}</div>
                        @php
                            $scolor = 'slate';
                            if ($sensor['condition'] == 'Normal' || $sensor['condition'] == 'Baik') $scolor = 'emerald';
                            elseif ($sensor['condition'] == 'Panas' || $sensor['condition'] == 'Kering' || $sensor['condition'] == 'Perhatian') $scolor = 'orange';
                        @endphp
                        <div class="text-[10px] font-semibold text-{{ $scolor }}-600 mt-0.5 bg-{{ $scolor }}-50 px-1.5 py-0.5 rounded text-center inline-block">
                            {{ $sensor['condition'] }}
                        </div>
                    </div>
                </div>
            </div>

            @if($sensor['type'] == 'water' || $sensor['type'] == 'weather' || $sensor['type'] == 'soil' || $sensor['type'] == 'terranir')
                </a>
            @endif
            @endforeach
        </div>
    </div>

    <form action="{{ route('lab.check') }}" method="POST" class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 space-y-5">
        @csrf
        
        <!-- Jenis Tanaman -->
        <div>
            <label class="block font-bold text-slate-800 mb-2">Pilih Jenis Tanaman</label>
            <div class="relative">
                <select name="plant_type" class="w-full appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-medium" required>
                    <option value="" disabled selected>-- Pilih Tanaman --</option>
                    <option value="Padi">Padi</option>
                    <option value="Cabai">Cabai</option>
                    <option value="Jagung">Jagung</option>
                    <option value="Tomat">Tomat</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            @error('plant_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Apa yang sudah dilakukan -->
        <div>
            <label class="block font-bold text-slate-800 mb-2">Tindakan Apa Saja Yang Baru Dilakukan?</label>
            <p class="text-xs text-slate-500 mb-3">Centang semua yang berlaku hari ini.</p>
            
            <div class="space-y-3">
                <label class="flex items-center p-3 border border-slate-100 rounded-xl bg-slate-50 hover:bg-emerald-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="actions_done[]" value="menyiram" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <span class="ml-3 text-sm font-medium text-slate-700">Menyiram Air</span>
                </label>
                <label class="flex items-center p-3 border border-slate-100 rounded-xl bg-slate-50 hover:bg-emerald-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="actions_done[]" value="memupuk_urea" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <span class="ml-3 text-sm font-medium text-slate-700">Memupuk Urea (N)</span>
                </label>
                <label class="flex items-center p-3 border border-slate-100 rounded-xl bg-slate-50 hover:bg-emerald-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="actions_done[]" value="memupuk_npk" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <span class="ml-3 text-sm font-medium text-slate-700">Memupuk NPK</span>
                </label>
                <label class="flex items-center p-3 border border-slate-100 rounded-xl bg-slate-50 hover:bg-emerald-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="actions_done[]" value="menyemprot_hama" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <span class="ml-3 text-sm font-medium text-slate-700">Menyemprot Hama / Pestisida</span>
                </label>
            </div>
            @error('actions_done')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 transition-colors mt-4 flex justify-center items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            Analisis Sekarang
        </button>
    </form>
</div>
@endsection
