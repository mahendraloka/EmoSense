@extends('layouts.app')

@section('content')
{{-- BACKGROUND DECORATION --}}
<div class="fixed inset-0 -z-10 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
    <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-sky-200/20 rounded-full blur-[120px]"></div>
</div>

<div class="max-w-4xl mx-auto px-6 space-y-10 pb-20">

    {{-- Navigasi Kembali --}}
    <a href="{{ route('artikel.index') }}"
       class="inline-flex items-center gap-2 text-slate-400 hover:text-sky-600 font-bold text-xs uppercase tracking-widest transition-colors group">
        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar
    </a>

    {{-- Gambar Header Heroic --}}
    @if($artikel->gambar)
        <div class="relative group">
            <div class="overflow-hidden rounded-[2.5rem] shadow-2xl border-4 border-white aspect-[16/9]">
                <img 
                    src="{{ asset('storage/'.$artikel->gambar) }}"
                    alt="{{ $artikel->judul }}"
                    class="w-full h-full object-cover">
            </div>
            {{-- Decorative Badge --}}
            <div class="absolute -bottom-4 right-8 bg-sky-600 text-white px-6 py-3 rounded-2xl shadow-xl font-black text-[10px] uppercase tracking-[0.2em]">
                Verified Content
            </div>
        </div>
    @endif

    {{-- Judul & Metadata --}}
    <div class="space-y-4 pt-4 text-center md:text-left">
        <h1 class="text-3xl md:text-5xl font-black text-slate-800 leading-[1.1] tracking-tight">
            {{ $artikel->judul }}
        </h1>
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-slate-200 text-[10px] font-bold text-slate-500 uppercase tracking-widest shadow-sm">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($artikel->tanggal_upload)->translatedFormat('d F Y') }}
            </span>
            <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
            <span class="text-[10px] font-bold text-sky-500 uppercase tracking-widest">Informasi Psikologi</span>
        </div>
    </div>

    {{-- Body Konten --}}
    <div class="bg-white/80 backdrop-blur-xl p-8 md:p-12 shadow-2xl shadow-slate-200/60 border border-white rounded-[3rem] relative">
        {{-- Ornament --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-1.5 bg-sky-200 rounded-full"></div>

        <div class="prose prose-slate prose-lg max-w-none 
                    prose-headings:font-black prose-headings:tracking-tight prose-headings:text-slate-800
                    prose-p:text-slate-600 prose-p:leading-relaxed prose-p:font-medium
                    prose-strong:text-sky-600 prose-strong:font-black
                    prose-img:rounded-3xl prose-img:shadow-lg">
            {!! $artikel->konten !!}
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <p class="text-xs text-slate-400 font-medium tracking-wide italic">"Pengetahuan adalah langkah awal menuju pemulihan diri."</p>
            </div>

            <button
                onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                Ke Atas
            </button>
        </div>
    </div>
</div>
@endsection