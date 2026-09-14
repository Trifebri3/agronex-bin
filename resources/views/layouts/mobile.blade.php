<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="Sistem Cerdas Agronomi Lahan denrawit x agronex. Pantau kualitas tanah, cuaca, dan air secara realtime.">
    <title>@yield('title', config('app.name', 'denrawit x agronex'))</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#10b981">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc; /* light gray bg */
            -webkit-tap-highlight-color: transparent;
        }
        /* Gradient text utility */
        .text-gradient {
            background: linear-gradient(135deg, #047857, #10b981); /* emerald-700 to emerald-500 */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50 md:flex">

    <!-- Sidebar (Desktop/iPad) / Bottom Navigation (Mobile) -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-slate-200 px-2 py-2 flex justify-around items-center pb-safe z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.05)] md:relative md:w-64 md:h-screen md:flex-col md:justify-start md:border-t-0 md:border-r md:pt-6 md:px-4 md:shadow-sm md:gap-2 transition-all">
        
        <!-- Brand Logo (Desktop Only) -->
        <div class="hidden md:flex items-center gap-2 mb-8 px-2 w-full">
            <img src="{{ asset('logo.png') }}" alt="Logo denrawit x agronex" class="w-8 h-8 object-contain">
            <h1 class="font-bold text-lg tracking-tight">denrawit <span class="text-emerald-500">x</span> agronex</h1>
        </div>

        <a href="{{ route('dashboard.index') }}" class="flex flex-col md:flex-row items-center md:w-full p-2 md:px-4 md:py-3 md:rounded-xl {{ request()->routeIs('dashboard.*') ? 'text-emerald-600 md:bg-emerald-50' : 'text-slate-400 md:text-slate-600 md:hover:bg-slate-50' }} transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 md:mb-0 md:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium">Beranda</span>
        </a>
        
        <a href="{{ route('iot.index') }}" class="flex flex-col md:flex-row items-center md:w-full p-2 md:px-4 md:py-3 md:rounded-xl {{ request()->routeIs('iot.*') ? 'text-emerald-600 md:bg-emerald-50' : 'text-slate-400 md:text-slate-600 md:hover:bg-slate-50' }} transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 md:mb-0 md:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894l6-3a1 1 0 01.894 0l5.447 2.724A1 1 0 0115 5.618v10.764a1 1 0 01-.553.894l-6 3a1 1 0 01-.894 0z" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium">Lahan</span>
        </a>

        <!-- FAB (Floating on Mobile, Standard Button on Desktop) -->
        <div class="relative -top-6 md:static md:w-full md:my-4 md:px-2">
            <a href="{{ route('diagnosis.index') }}" class="flex items-center justify-center w-14 h-14 md:w-full md:h-12 md:rounded-xl bg-emerald-500 rounded-full shadow-lg shadow-emerald-500/30 text-white hover:scale-105 active:scale-95 transition-transform duration-200 border-4 border-white md:border-none md:shadow-md md:gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="absolute -bottom-5 w-full text-center text-[10px] font-medium text-slate-500 whitespace-nowrap -ml-2 md:static md:w-auto md:text-sm md:text-white md:ml-0">Cek Tanaman</span>
            </a>
        </div>

        <a href="{{ route('chat.index') }}" class="flex flex-col md:flex-row items-center md:w-full p-2 md:px-4 md:py-3 md:rounded-xl {{ request()->routeIs('chat.*') ? 'text-emerald-600 md:bg-emerald-50' : 'text-slate-400 md:text-slate-600 md:hover:bg-slate-50' }} transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 md:mb-0 md:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium">Tanya AI</span>
        </a>

        <a href="{{ route('lab.index') }}" class="flex flex-col md:flex-row items-center md:w-full p-2 md:px-4 md:py-3 md:rounded-xl {{ request()->routeIs('lab.*') ? 'text-emerald-600 md:bg-emerald-50' : 'text-slate-400 md:text-slate-600 md:hover:bg-slate-50' }} transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 md:mb-0 md:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium">LAB</span>
        </a>
    </nav>

    <!-- Main Content Area -->
    <div class="flex-1 w-full min-h-screen pb-20 md:pb-0 h-screen md:overflow-y-auto">
        <!-- Top App Bar (Visible Mobile, Optional Desktop) -->
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-slate-100 shadow-sm px-4 py-3 flex justify-between items-center md:bg-transparent md:border-none md:shadow-none md:py-6 md:px-8 md:static">
            <div class="flex items-center gap-2 md:hidden">
                <img src="{{ asset('logo.png') }}" alt="Logo denrawit x agronex" width="32" height="32" class="w-8 h-8 object-contain">
                <h1 class="font-bold text-lg tracking-tight">denrawit <span class="text-emerald-500">x</span> agronex</h1>
            </div>
            <div class="hidden md:block">
                <!-- Empty div to push logout to the right on desktop -->
            </div>
            <div class="flex items-center gap-3">
                @if(session('petani_id'))
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition-colors bg-white rounded-full shadow-sm border border-slate-100 md:px-4 md:py-2 md:rounded-lg md:flex md:items-center md:gap-2" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="hidden md:inline text-sm font-semibold">Keluar</span>
                        </button>
                    </form>
                @endif
            </div>
        </header>

        <main class="md:max-w-6xl md:mx-auto md:px-4">
            @yield('content')
        </main>
    </div>

    <!-- Support for safe area inset on modern mobile browsers (iOS) -->
    <style>
        .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0.5rem); }
    </style>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
    @stack('scripts')
</body>
</html>
