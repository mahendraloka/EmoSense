<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EmoSense</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 antialiased">

<div class="flex min-h-screen overflow-hidden">

    {{-- LEFT SECTION: Decorative (Hidden on mobile) --}}
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-600 via-indigo-700 to-indigo-900 items-center justify-center p-12 relative">
        {{-- Abstract Shapes --}}
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 text-white max-w-lg">
            {{-- Logo Card --}}
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 inline-flex items-center gap-4 mb-12 border border-white/20 shadow-2xl">
                <div class="bg-white p-2 rounded-2xl">
                    <img src="{{ asset('img/logo.png') }}" alt="EmoSense" class="w-12 h-12">
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">EmoSense</h1>
                    <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold">Self-Awareness Hub</p>
                </div>
            </div>

            <h2 class="text-4xl font-bold leading-tight mb-6 tracking-tight">
                Kenali kondisi emosimu <br><span class="text-blue-300 italic text-3xl font-light">dengan lebih sadar.</span>
            </h2>

            <p class="text-lg text-blue-100/80 leading-relaxed mb-10 font-light">
                Pantau tingkat stres, kecemasan, dan depresi menggunakan standar klinis 
                <span class="font-semibold text-white underline decoration-blue-400">DASS-21</span> 
                secara aman dan terstruktur.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-xl">📊</div>
                    <span class="text-blue-50 font-medium">Self assessment berbasis psikologi</span>
                </div>
                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-xl">✨</div>
                    <span class="text-blue-50 font-medium">Visualisasi hasil yang intuitif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT SECTION: Form --}}
    <div class="flex w-full lg:w-1/2 items-center justify-center p-6 md:p-12">
        <div class="w-full max-w-md">
            {{-- Mobile Logo --}}
            <div class="flex lg:hidden justify-center mb-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" alt="EmoSense" class="w-10 h-10">
                    <span class="text-2xl font-bold text-slate-800">EmoSense</span>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 p-8 md:p-10 border border-slate-100">
                <header class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight mb-2">Selamat Datang Kembali</h2>
                    <p class="text-slate-500 font-light">Masuk untuk melanjutkan pemantauanmu</p>
                </header>

                @if ($errors->any())
                    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-xl text-sm mb-6 flex items-center gap-3">
                        <span>⚠️</span>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Alamat Email</label>
                        <input type="email" name="email" required placeholder="nama@email.com"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-blue-200 hover:shadow-blue-300 active:scale-[0.98]">
                        Masuk ke Akun
                    </button>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-slate-500 text-sm">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-700 underline decoration-blue-200 underline-offset-4">Daftar Sekarang</a>
                    </p>
                    
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <p class="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold">
                            © 2025 EmoSense · Indonesia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>