<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>EmoSense Admin - @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen relative">
        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity"></div>

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')

        {{-- CONTENT AREA --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Navbar Mobile Only --}}
            <header class="lg:hidden bg-white border-b px-4 py-3 flex items-center justify-between sticky top-0 z-30">
                <span class="font-bold text-blue-600">EmoSense</span>
                <button @click="sidebarOpen = true" class="p-2 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
            </header>

            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @if(session('success'))
        <script>Swal.fire('Berhasil', '{{ session("success") }}', 'success')</script>
    @endif
    @yield('scripts')
</body>
</html>