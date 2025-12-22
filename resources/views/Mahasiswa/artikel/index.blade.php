@extends('layouts.app')

@section('content')
{{-- GLOBAL WRAPPER DENGAN BACKGROUND DEKORATIF --}}
<div class="relative overflow-hidden min-h-screen">
    {{-- BACKGROUND DECORATION (Identik dengan Home & Mood Tracker) --}}
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
        <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 space-y-10 pb-20 pt-4">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-100 text-sky-600 text-[10px] font-black uppercase tracking-widest">
                    📚 Library Edukasi
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight">Artikel Kesehatan Mental</h1>
                <p class="text-slate-500 font-medium max-w-lg">
                    Temukan wawasan dan tips praktis dari para profesional untuk menjaga kesejahteraan emosionalmu.
                </p>
            </div>

            {{-- Search Bar Modern --}}
            <form action="{{ route('artikel.index') }}" method="GET" class="w-full md:max-w-sm">
                <div class="relative group">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari topik kesehatan..."
                        class="w-full bg-white/80 backdrop-blur-md border border-slate-200 rounded-2xl py-3.5 pl-12 pr-4 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 focus:bg-white transition-all outline-none font-medium shadow-sm group-hover:shadow-md"
                    >
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-hover:text-sky-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </form>
        </div>

        {{-- Grid Artikel --}}
        @if($artikels->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($artikels as $artikel)
                    <div class="group flex flex-col bg-white/70 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 overflow-hidden">

                        {{-- Gambar Card --}}
                        <div class="relative h-56 w-full bg-slate-100 overflow-hidden">
                            @if($artikel->gambar)
                                <img 
                                    src="{{ asset('storage/'.$artikel->gambar) }}"
                                    alt="{{ $artikel->judul }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-2">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">No Image available</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[9px] font-black text-sky-600 uppercase tracking-widest shadow-sm">
                                    Mental Health
                                </span>
                            </div>
                        </div>

                        {{-- Konten Card --}}
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-3">
                                <span>📅 {{ \Carbon\Carbon::parse($artikel->tanggal_upload)->translatedFormat('d M Y') }}</span>
                            </div>

                            <h2 class="text-xl font-black text-slate-800 leading-tight mb-4 group-hover:text-sky-600 transition-colors line-clamp-2">
                                {{ $artikel->judul }}
                            </h2>

                            <p class="text-slate-500 text-sm font-medium line-clamp-3 mb-6 flex-1 italic">
                                "{{ Str::limit(strip_tags($artikel->konten), 120) }}"
                            </p>

                            <a href="{{ route('artikel.show', $artikel->id_Artikel) }}"
                               class="inline-flex items-center gap-2 text-sky-600 font-black text-xs uppercase tracking-[0.2em] group/btn hover:gap-3 transition-all">
                                Baca Artikel <span class="text-lg leading-none transition-transform group-hover/btn:translate-x-1">→</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-20 text-center bg-white/50 backdrop-blur rounded-[3rem] border-2 border-dashed border-slate-200">
                <span class="text-5xl mb-4 block">🔍</span>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada artikel tersedia untuk pencarian ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection