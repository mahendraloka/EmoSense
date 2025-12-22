<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed lg:sticky top-0 left-0 z-50 w-72 bg-[#0F172A] text-gray-300 h-screen transition-transform duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none"
    x-data="{ openUser: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }"
>
    {{-- Close Button Mobile --}}
    <button @click="sidebarOpen = false" class="lg:hidden absolute right-4 top-4 text-gray-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    <div class="p-8">
        <h2 class="text-3xl font-black tracking-tight text-white italic">
            Emo<span class="text-blue-400">Sense</span>
        </h2>
        <div class="flex items-center gap-2 mt-2">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em]">Admin Panel</p>
        </div>
    </div>

    <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
        <p class="text-[10px] uppercase tracking-[2px] text-gray-500 font-bold px-4 mb-2">Menu Utama</p>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-white/5 hover:text-white' }}">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
           <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.pertanyaan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.pertanyaan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-white/5 hover:text-white' }}">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/><path d="M7 8h5M7 12h8M7 16h8"/></svg>
           <span class="font-medium">Kelola Pertanyaan</span>
        </a>

        <a href="{{ route('admin.artikel.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.artikel.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-white/5 hover:text-white' }}">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/><path d="M7 8h5M7 12h8M7 16h8"/></svg>
           <span class="font-medium">Kelola Artikel</span>
        </a>

        {{-- Dropdown User dengan UI lebih rapi --}}
        <div class="pt-2">
            <button @click="openUser = !openUser" 
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="font-medium">Manajemen User</span>
                </div>
                <svg :class="openUser ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openUser" x-transition class="mt-1 ml-4 border-l border-gray-700 pl-4 space-y-1">
                <a href="{{ route('admin.users.index', ['type' => 'mahasiswa']) }}" class="block py-2 text-sm hover:text-white {{ request()->fullUrlIs('*type=mahasiswa*') ? 'text-blue-400 font-bold' : '' }}">Mahasiswa</a>
                <a href="{{ route('admin.users.index', ['type' => 'psikolog']) }}" class="block py-2 text-sm hover:text-white {{ request()->fullUrlIs('*type=psikolog*') ? 'text-blue-400 font-bold' : '' }}">Psikolog</a>
                <a href="{{ route('admin.users.index', ['type' => 'admin']) }}" class="block py-2 text-sm hover:text-white {{ request()->fullUrlIs('*type=admin*') ? 'text-blue-400 font-bold' : '' }}">Admin</a>
            </div>
        </div>
    </nav>

    <div class="p-4 border-t border-gray-800">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white py-3 rounded-xl transition-all font-semibold">
                🚪 Logout
            </button>
        </form>
    </div>
</aside>