<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Login - denrawit x agronex</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#10b981">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm bg-white rounded-3xl p-8 shadow-xl shadow-emerald-500/10 border border-slate-100">
        <div class="text-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-20 h-20 object-contain mx-auto mb-4 drop-shadow-md">
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Selamat Datang</h1>
            <p class="text-slate-500 text-sm mt-1">Masukkan ID Anda untuk masuk ke sistem.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="petani_id" class="block text-sm font-medium text-slate-700 mb-2">ID Petani</label>
                <input type="text" name="petani_id" id="petani_id" required 
                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all" 
                       placeholder="Contoh: PETANI-001">
                @error('petani_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-emerald-600 text-white font-semibold py-3 rounded-xl shadow-md hover:bg-emerald-700 transition-all active:scale-[0.98]">
                Masuk
            </button>
        </form>
    </div>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
</body>
</html>
