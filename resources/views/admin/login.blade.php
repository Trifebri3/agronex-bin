<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Backdoor - denrawit x agronex</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm bg-slate-800 rounded-3xl shadow-xl overflow-hidden border border-slate-700">
        <div class="p-8">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center border-4 border-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>
            
            <h2 class="text-2xl font-bold text-center text-white mb-2">Admin Backdoor</h2>
            <p class="text-slate-400 text-center text-sm mb-8">Masukkan kata sandi rahasia untuk masuk.</p>

            @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-3 rounded-lg text-sm mb-6 text-center">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <input type="password" name="password" required autofocus class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-center text-lg tracking-widest placeholder:text-slate-600 placeholder:tracking-normal" placeholder="Password...">
                </div>

                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition-colors">
                    Masuk
                </button>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('dashboard.index') }}" class="text-slate-500 text-sm hover:text-white transition-colors">← Kembali ke Aplikasi</a>
            </div>
        </div>
    </div>
</body>
</html>
