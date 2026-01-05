@php $admin = auth('admin')->user(); @endphp

<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed lg:sticky top-0 left-0 z-50 w-72 bg-[#0F172A] text-gray-300 h-screen transition-transform duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none"
    x-data="{ openUser: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }"
>
    {{-- Header Sidebar --}}
    <div class="relative p-8 flex-shrink-0">
        <button @click="sidebarOpen = false" class="lg:hidden absolute right-4 top-4 text-gray-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-md">
            <h2 class="text-3xl font-black tracking-tight text-white italic">
                Emo<span class="text-blue-400">Sense</span>
            </h2>
        </div>
        <div class="flex items-center gap-2 mt-2">
            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em]">Admin Panel</p>
        </div>
    </div>

    {{-- Profil Card (Adaptasi dari Psikolog) --}}
    <div class="px-4 mb-6 flex-shrink-0">
        <a href="{{ route('admin.profile.edit') }}" 
           class="group flex items-center gap-4 p-4 rounded-[2rem] bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 shadow-inner">
            <div class="relative">
                {{-- Menggunakan Inisial karena tabel admin tidak ada foto --}}
                <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-black text-lg ring-2 ring-blue-400/30 group-hover:ring-blue-400 transition-all">
                    {{ substr($admin->nama, 0, 1) }}
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-[#0F172A] rounded-full"></div>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">{{ $admin->nama }}</p>
                <p class="text-[10px] text-gray-500 truncate font-medium uppercase tracking-wider">Administrator</p>
            </div>
        </a>
    </div>

    {{-- Area Navigasi --}}
    <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar min-h-0">
        <p class="text-[10px] uppercase tracking-[2px] text-gray-500 font-bold px-4 mb-2">Menu Utama</p>
        
        <a href="{{ route('admin.dashboard') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.pertanyaan.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.pertanyaan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="font-medium text-sm">Kelola Pertanyaan</span>
        </a>

        <a href="{{ route('admin.artikel.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.artikel.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h5M7 12h8M7 16h8"/></svg>
            <span class="font-medium text-sm">Kelola Artikel</span>
        </a>

        {{-- Manajemen User --}}
        <div class="pt-2">
            <button @click="openUser = !openUser" 
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="font-medium text-sm">Manajemen User</span>
                </div>
                <svg :class="openUser ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openUser" x-transition class="mt-1 ml-4 border-l border-gray-700 pl-4 space-y-1 text-sm">
                <a href="{{ route('admin.users.index', ['type' => 'mahasiswa']) }}" class="block py-2 hover:text-white {{ request()->fullUrlIs('*type=mahasiswa*') ? 'text-blue-400 font-bold' : '' }}">Mahasiswa</a>
                <a href="{{ route('admin.users.index', ['type' => 'psikolog']) }}" class="block py-2 hover:text-white {{ request()->fullUrlIs('*type=psikolog*') ? 'text-blue-400 font-bold' : '' }}">Psikolog</a>
                <a href="{{ route('admin.users.index', ['type' => 'admin']) }}" class="block py-2 hover:text-white {{ request()->fullUrlIs('*type=admin*') ? 'text-blue-400 font-bold' : '' }}">Admin</a>
            </div>
        </div>
    </nav>

    {{-- Footer Sidebar Logout --}}
    <div class="p-6 mt-auto flex-shrink-0 border-t border-white/5">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full flex items-center justify-center gap-3 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white py-3.5 rounded-2xl transition-all duration-300 font-bold text-xs uppercase tracking-widest shadow-sm">
                <span>🚪</span> Logout
            </button>
        </form>
    </div>
</aside>