@php $psikolog = auth('psikolog')->user(); @endphp

<aside 
    {{-- Tambahkan logic sticky dan h-screen --}}
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0F172A] text-gray-300 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen flex flex-col shadow-2xl shadow-gray-900/50"
>
    {{-- Header Sidebar --}}
    <div class="p-8 flex-shrink-0">
        <h2 class="text-3xl font-black tracking-tight text-white italic">
            Emo<span class="text-green-400">Sense</span>
        </h2>
        <div class="flex items-center gap-2 mt-2">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em]">Psikolog Panel</p>
        </div>
    </div>

    {{-- Profil Card --}}
    <div class="px-4 mb-8 flex-shrink-0">
        <a href="{{ route('psikolog.profile.edit') }}" 
           class="group flex items-center gap-4 p-4 rounded-[2rem] bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 shadow-inner">
            <div class="relative">
                <img src="{{ $psikolog->foto_profil ? asset('storage/' . $psikolog->foto_profil) : asset('img/default-avatar.png') }}"
                     class="w-12 h-12 rounded-2xl object-cover ring-2 ring-green-400/30 group-hover:ring-green-400 transition-all" alt="Avatar">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-[#0F172A] rounded-full"></div>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-white truncate group-hover:text-green-400 transition-colors">{{ $psikolog->nama }}</p>
                <p class="text-[10px] text-gray-500 truncate font-medium uppercase tracking-wider">{{ $psikolog->spesialisasi }}</p>
            </div>
        </a>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto custom-scrollbar pb-6">
        <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Utama</p>
        
        <a href="{{ route('psikolog.dashboard') }}"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl transition-all duration-200 group
           {{ request()->routeIs('psikolog.dashboard') ? 'bg-green-500 text-white shadow-lg shadow-green-500/20' : 'hover:bg-white/5 hover:text-white' }}">
           <span class="text-xl">📊</span>
           <span class="font-semibold tracking-wide">Dashboard</span>
        </a>

        <a href="{{ route('psikolog.mahasiswa.index') }}"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl transition-all duration-200 group
           {{ request()->routeIs('psikolog.mahasiswa.*') ? 'bg-green-500 text-white shadow-lg shadow-green-500/20' : 'hover:bg-white/5 hover:text-white' }}">
           <span class="text-xl">👥</span>
           <span class="font-semibold tracking-wide text-sm">Data Mahasiswa</span>
        </a>
    </nav>

    {{-- Logout --}}
    <div class="p-6 mt-auto flex-shrink-0 border-t border-white/5">
        <form action="{{ route('psikolog.logout') }}" method="POST">
            @csrf
            <button class="w-full flex items-center justify-center gap-3 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white py-3.5 rounded-2xl transition-all duration-300 font-bold text-xs uppercase tracking-widest shadow-sm">
                <span>🚪</span> Logout Sistem
            </button>
        </form>
    </div>
</aside>