@extends('layouts.mobile')

@section('title', 'Beranda - Agronex')

@section('content')
<div class="px-4 py-6 space-y-6">
    
    <!-- Greeting -->
    <div>
        <h2 class="text-2xl font-bold">Halo, Petani <span class="text-emerald-500">Hebat!</span></h2>
        <p class="text-slate-500 mt-1">Mau mengecek apa hari ini?</p>
    </div>

    <!-- Quick Navigation (Step 01) -->
    <div class="grid grid-cols-2 gap-3">
        <a href="{{ route('iot.index') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-500 transition-colors flex flex-col items-center justify-center text-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="text-xs font-bold text-slate-700">Kondisi Lahan</span>
        </a>
        <a href="{{ route('diagnosis.index') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-500 transition-colors flex flex-col items-center justify-center text-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span class="text-xs font-bold text-slate-700">Kondisi Tanaman</span>
        </a>
        <a href="{{ route('automation.index') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-500 transition-colors flex flex-col items-center justify-center text-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            <span class="text-xs font-bold text-slate-700">Smart Irrigation</span>
        </a>
        <a href="#rencanaTindakan" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-500 transition-colors flex flex-col items-center justify-center text-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            <span class="text-xs font-bold text-slate-700">Rencana Tindakan</span>
        </a>
    </div>

    <!-- Lahan Saya Global Status -->
    <div class="mt-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-slate-800">Lahan Saya</h3>
            <button class="text-sm font-semibold text-emerald-600">+ Tambah Lahan</button>
        </div>

        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-5 text-white shadow-lg overflow-hidden relative">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="font-bold text-xl">{{ $farm_name }}</h4>
                        <p class="text-slate-300 text-sm">{{ $crop_type }} • {{ $farm_area }} Ha</p>
                    </div>
                    <!-- Status Icon Badge -->
                    @if($statusGlobal == 'BAIK')
                    <div class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> BAIK
                    </div>
                    @elseif($statusGlobal == 'PERHATIAN')
                    <div class="bg-amber-500/20 border border-amber-500/30 text-amber-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span> PERHATIAN
                    </div>
                    @else
                    <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span> TINDAKAN
                    </div>
                    @endif
                </div>

                <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/10">
                    <h5 class="text-sm font-semibold mb-1 text-slate-100">Kondisi Hari Ini</h5>
                    <p class="text-xs text-slate-300">{{ $globalMessage }}</p>
                </div>
            </div>

            <!-- Decorations -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-{{ $globalColor }}-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-{{ $globalColor }}-600/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Analisis Detail "APA, KENAPA, HARUS APA, KAPAN" -->
    @if(count($issues) > 0)
    <div class="mt-8 space-y-4">
        <h3 class="font-bold text-lg text-slate-800">Rekomendasi Agronex</h3>
        
        @foreach($issues as $issue)
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full @if($issue['type'] == 'water') bg-blue-500 @elseif($issue['type'] == 'fertilizer') bg-green-500 @elseif($issue['type'] == 'weather') bg-amber-500 @else bg-red-500 @endif"></div>
            
            <div class="flex items-center gap-3 mb-4">
                <span class="text-emerald-600 flex-shrink-0">
                    @if($issue['icon'] == 'water')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    @elseif($issue['icon'] == 'plant')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    @elseif($issue['icon'] == 'cloud')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                    @elseif($issue['icon'] == 'alert')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    @endif
                </span>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $issue['type'] == 'fertilizer' ? 'Nutrisi' : ($issue['type'] == 'water' ? 'Irigasi' : 'Cuaca') }}</div>
                    <h4 class="font-bold text-slate-800">{{ $issue['title'] }}</h4>
                </div>
            </div>

            <div class="space-y-3 text-sm text-slate-600">
                <div>
                    <strong class="text-slate-800 block text-xs mb-0.5">KENAPA?</strong>
                    {{ $issue['desc'] }}
                </div>
                <div>
                    <strong class="text-slate-800 block text-xs mb-0.5">HARUS APA?</strong>
                    {{ $issue['action'] }}
                </div>
                <div>
                    <strong class="text-slate-800 block text-xs mb-0.5">KAPAN?</strong>
                    {{ $issue['time'] }}
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('chat.index') }}" class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    [ Tanya Agronex Detailnya ]
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- RENCANA TINDAKAN (Action Plan) -->
    <div id="rencanaTindakan" class="mt-8 bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                Rencana Tindakan
            </h3>
        </div>

        <div class="space-y-3">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">HARI INI</h4>
            
            @if(count($actionPlans) > 0)
                @foreach($actionPlans as $plan)
                <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors">
                    <div class="pt-0.5">
                        <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 action-checkbox" data-id="{{ $plan['id'] }}">
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800 {{ $plan['priority'] == 'high' ? 'text-red-600' : '' }} text-sm">{{ $plan['title'] }}</div>
                        <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $plan['time'] }}
                        </div>
                    </div>
                </label>
                @endforeach
            @else
                <div class="text-center py-6 text-slate-500 text-sm">
                    Tugas hari ini sudah selesai atau tidak ada jadwal mendesak.
                </div>
            @endif

            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-6 pt-4 border-t border-slate-100">BESOK</h4>
            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors opacity-70">
                <div class="pt-0.5">
                    <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                </div>
                <div class="flex-1">
                    <div class="font-semibold text-slate-800 text-sm">Evaluasi Nutrisi (Pengecekan NPK)</div>
                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Pagi
                    </div>
                </div>
            </label>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.action-checkbox').forEach(box => {
        box.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const parent = this.closest('label');
            
            if(this.checked) {
                parent.querySelector('.font-semibold').classList.add('line-through', 'text-slate-400');
                parent.classList.add('bg-slate-50');
            } else {
                parent.querySelector('.font-semibold').classList.remove('line-through', 'text-slate-400');
                parent.classList.remove('bg-slate-50');
            }

            // Sync with server
            fetch('{{ route("dashboard.check-action-plan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, completed: this.checked })
            });
        });
    });
</script>
@endpush
@endsection
