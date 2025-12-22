<!DOCTYPE html>
<html lang="id" x-data="{ mobileMenu: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EmoSense' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak]{display:none!important}
        html { scroll-behavior: smooth; font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>    
</head>

<body class="bg-slate-50 min-h-screen text-slate-800">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50">
        <nav class="backdrop-blur-xl bg-white/70 border-b border-white/40 shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">

                {{-- Brand --}}
                <a href="{{ route('mahasiswa.home') }}" class="flex items-center gap-3 active:scale-95 transition-transform">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-md">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">EmoSense</h1>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center gap-8 text-sm font-semibold">
                    <a href="{{ route('mahasiswa.home') }}" class="text-slate-600 hover:text-sky-600 transition">Home</a>
                    <a href="{{ route('artikel.index') }}" class="text-slate-600 hover:text-sky-600 transition">Artikel</a>

                    {{-- Profile Dropdown --}}
                    <div x-data="{ open:false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 bg-white px-3 py-2 rounded-2xl border border-slate-200 shadow-sm hover:shadow transition-all">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-500 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(Auth::guard('mahasiswa')->user()->nama,0,1)) }}
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" x-cloak @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-64 bg-white rounded-[1.5rem] shadow-2xl border border-slate-100 overflow-hidden py-2">
                            <div class="px-5 py-4 border-b border-slate-50 bg-slate-50/50">
                                <p class="font-bold text-slate-900 truncate">{{ Auth::guard('mahasiswa')->user()->nama }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::guard('mahasiswa')->user()->email }}</p>
                            </div>
                            <a href="{{ route('mahasiswa.profile.edit') }}" class="flex items-center gap-3 px-5 py-3 text-sm hover:bg-sky-50 text-slate-700 transition">⚙️ Pengaturan Akun</a>
                            <form action="{{ route('logout.mahasiswa') }}" method="POST">
                                @csrf
                                <button class="w-full text-left flex items-center gap-3 px-5 py-3 text-sm text-rose-600 hover:bg-rose-50 transition">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu Trigger --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-600 bg-slate-100 rounded-xl">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile Drawer --}}
            <div x-show="mobileMenu" x-cloak x-transition class="md:hidden bg-white border-t border-slate-100 px-6 py-8 space-y-6 shadow-xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-sky-200">
                        {{ strtoupper(substr(Auth::guard('mahasiswa')->user()->nama,0,1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 leading-none">{{ Auth::guard('mahasiswa')->user()->nama }}</p>
                        <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-widest leading-none">Mahasiswa</p>
                    </div>
                </div>
                <div class="grid gap-2">
                    <a href="{{ route('mahasiswa.home') }}" class="flex items-center px-4 py-3 rounded-xl bg-slate-50 font-semibold">🏠 Home</a>
                    <a href="{{ route('artikel.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-50 font-semibold transition">📑 Artikel</a>
                    <a href="{{ route('mahasiswa.profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-50 font-semibold transition">⚙️ Akun</a>
                </div>
                <form action="{{ route('logout.mahasiswa') }}" method="POST">
                    @csrf
                    <button class="w-full text-center py-4 text-rose-600 font-bold bg-rose-50 rounded-2xl mt-4 transition active:scale-95">Logout</button>
                </form>
            </div>
        </nav>
    </header>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-10 min-h-[75vh]">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="text-center text-xs text-slate-400 py-12 px-6">
        <div class="max-w-xs mx-auto border-t border-slate-200 pt-8 italic leading-relaxed">
            © 2025 EmoSense • Built with care for student wellness
        </div>
    </footer>

    @yield('scripts')

</body>
</html>