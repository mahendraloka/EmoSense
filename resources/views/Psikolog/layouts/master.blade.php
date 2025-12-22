<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>EmoSense Psikolog - @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="bg-[#F8FAFC]">

    {{-- Overlay Mobile --}}
    <div x-show="sidebarOpen" 
         x-transition:enter="transition opacity-ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition opacity-ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"></div>

    <div class="flex min-h-screen items-start">
        @include('psikolog.layouts.sidebar')

        <div class="flex flex-col flex-1 w-full">
            {{-- Header Mobile --}}
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b lg:hidden shadow-sm">
                <h2 class="text-xl font-extrabold tracking-tight text-gray-800">
                    Emo<span class="text-green-500">Sense</span>
                </h2>
                <button @click="sidebarOpen = true" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </header>

            <main class="flex-1 p-4 lg:p-10">
                {{-- Flash Message --}}
                @if(session('success') || session('error'))
                    <div class="max-w-4xl mx-auto mb-6">
                        @if(session('success'))
                            <div class="flex items-center gap-3 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 shadow-sm animate-fade-in">
                                <span class="p-2 bg-green-100 rounded-full">✅</span>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="flex items-center gap-3 p-4 bg-red-50 text-red-700 rounded-2xl border border-red-100 shadow-sm animate-fade-in">
                                <span class="p-2 bg-red-100 rounded-full">⚠️</span>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Load Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>