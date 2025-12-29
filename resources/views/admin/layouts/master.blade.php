<!DOCTYPE html>
<html lang="id" class="bg-[#0F172A]" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EmoSense Admin - @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    <style>
        html, body { 
            background-color: #0F172A; 
            overscroll-behavior-y: none;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#0F172A] text-gray-900 overflow-x-hidden">
    <div class="flex min-h-screen w-full bg-[#0F172A] relative">
        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition opacity-ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity-ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity"></div>

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')

        {{-- CONTENT AREA --}}
        <div class="flex flex-col flex-1 min-w-0 bg-[#0F172A] lg:bg-gray-50">
            {{-- Top Navbar Mobile --}}
            <header class="sticky top-0 z-30 flex items-center justify-between px-6 py-4 bg-[#0F172A] lg:hidden shadow-xl border-none outline-none -mt-px">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    <h2 class="text-xl font-extrabold tracking-tight text-white italic">
                        Emo<span class="text-blue-400">Sense</span>
                    </h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="p-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all border border-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </header>

            <div class="flex-1 bg-gray-50 relative">
                <main class="flex-1 p-4 md:p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>Swal.fire('Berhasil', '{{ session("success") }}', 'success')</script>
    @endif
    @yield('scripts')
</body>
</html>