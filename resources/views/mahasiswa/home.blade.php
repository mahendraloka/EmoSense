@extends('layouts.app')

@section('content')

{{-- GLOBAL WRAPPER --}}
<div class="relative overflow-hidden">

    {{-- FIXED BACKGROUND DECORATION --}}
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
        <div class="absolute -top-40 -right-40 w-[40rem] h-[40rem] bg-sky-200/30 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute top-[30%] -left-48 w-[36rem] h-[36rem] bg-teal-100/40 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-0 w-[32rem] h-[32rem] bg-indigo-100/30 rounded-full blur-[100px]"></div>
    </div>

    {{-- Dikurangi space antar section untuk kenyamanan scrolling --}}
    <div class="space-y-24 md:space-y-32">

        {{-- =====================
            HERO SECTION
            Padding top (pt) dikurangi agar tidak banyak space kosong dengan header
        ===================== --}}
        <section 
            x-data="{ show: false }" 
            x-init="setTimeout(() => show = true, 100)"
            class="relative max-w-7xl mx-auto px-6 md:px-12 lg:px-20 pt-4 md:pt-10"
        >
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                
                {{-- TEXT CONTENT --}}
                <div class="max-w-2xl text-center lg:text-left order-2 lg:order-1">
                    @auth
                    <div x-cloak x-show="show" x-transition.duration.800ms class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-50 border border-sky-100 text-sky-700 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                        </span>
                        Selamat datang kembali, {{ Auth::user()->nama ?? Auth::user()->name }}
                    </div>
                    @endauth

                    <h1 x-cloak x-show="show" x-transition.delay.300ms
                        class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 py-2 leading-[1.2] md:leading-[1.15]"
                    >
                        Ruang aman untuk <br class="hidden md:block">
                        <span class="inline-block text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-teal-500 italic px-1 pb-2">
                            kesehatan mentalmu.
                        </span>
                    </h1>

                    <p x-cloak x-show="show" x-transition.delay.500ms
                       class="text-base md:text-lg text-slate-500 leading-relaxed max-w-lg mx-auto lg:mx-0 font-medium"
                    >
                        EmoSense adalah teman perjalananmu. Tempat untuk memahami diri tanpa tekanan, tanpa penghakiman. Cukup kamu dan refleksi dirimu.
                    </p>

                    <div x-cloak x-show="show" x-transition.delay.700ms
                         class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4"
                    >
                        <a href="#features" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-slate-900 text-white font-bold shadow-2xl shadow-slate-900/30 hover:bg-slate-800 transition-all hover:-translate-y-1 active:scale-95">
                           🧠 Mulai Assessment
                        </a>

                        <a href="#features" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white/80 backdrop-blur-md border border-slate-200 text-slate-700 font-bold shadow-sm hover:bg-white transition-all hover:-translate-y-1 active:scale-95">
                           📅 Catat Mood
                        </a>
                    </div>
                </div>

                {{-- IMAGE / ILLUSTRATION --}}
                <div x-cloak x-show="show" x-transition.scale.90.delay.200ms
                     class="relative flex justify-center order-1 lg:order-2"
                >
                    <div class="absolute inset-0 bg-sky-200 rounded-full blur-[80px] opacity-20"></div>
                    <img src="{{ asset('img/hero-image.png') }}" 
                         alt="Wellness Illustration" 
                         class="relative w-full max-w-sm md:max-w-lg rounded-[3rem] shadow-[0_32px_64px_-12px_rgba(0,0,0,0.1)] transition-transform duration-700 hover:rotate-1">
                </div>
            </div>
        </section>

        {{-- =====================
            FEATURE SECTION
            scroll-mt-24 berfungsi agar posisi scroll pas di bawah navbar sticky
        ===================== --}}
        <section id="features" class="scroll-mt-24 max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4 tracking-tight leading-[1.2]">Mulai dari satu langkah kecil</h2>
                <p class="text-sm md:text-base text-slate-500 font-medium leading-relaxed">
                    Pilih fitur yang paling kamu butuhkan saat ini. Konsistensi kecil membawa perubahan besar bagi kesehatan mentalmu.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                {{-- Assessment Card --}}
                <a href="{{ route('selfassessment.index') }}"
                   class="group relative overflow-hidden rounded-[2.5rem] p-10 md:p-14 bg-white/70 backdrop-blur-xl border border-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 active:scale-[0.98]">
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-sky-100 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-16 h-16 bg-sky-50 rounded-2xl flex items-center justify-center text-4xl mb-10 group-hover:scale-110 transition-transform duration-500 shadow-sm">🧠</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4 tracking-tight">Self Assessment</h3>
                    <p class="text-sm md:text-base text-slate-500 leading-relaxed font-medium">Identifikasi tingkat stres, kecemasan, dan depresi secara mandiri menggunakan standar klinis DASS-21.</p>
                    <div class="mt-10 flex items-center text-sky-600 font-bold gap-2">Mulai Tes <span class="group-hover:translate-x-2 transition-transform">→</span></div>
                </a>

                {{-- Mood Tracker Card --}}
                <a href="{{ route('moodtracker.index') }}"
                   class="group relative overflow-hidden rounded-[2.5rem] p-10 md:p-14 bg-white/70 backdrop-blur-xl border border-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 active:scale-[0.98]">
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-teal-100 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-16 h-16 bg-teal-50 rounded-2xl flex items-center justify-center text-4xl mb-10 group-hover:scale-110 transition-transform duration-500 shadow-sm">📅</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4 tracking-tight">Mood Tracker</h3>
                    <p class="text-sm md:text-base text-slate-500 leading-relaxed font-medium">Rekam suasana hatimu setiap hari untuk mengenali pola emosional dan memantau pemicu perubahan mood kamu.</p>
                    <div class="mt-10 flex items-center text-teal-600 font-bold gap-2">Catat Mood <span class="group-hover:translate-x-2 transition-transform">→</span></div>
                </a>
            </div>
        </section>

        {{-- CLOSING SECTION --}}
        <section class="pb-32 px-6 text-center">
            <div class="max-w-3xl mx-auto bg-white/40 backdrop-blur-md rounded-[3rem] p-12 border border-white shadow-sm">
                <div class="inline-flex items-center justify-center w-12 h-1 bg-sky-200 rounded-full mb-8"></div>
                <p class="text-xl md:text-2xl text-slate-700 font-semibold leading-relaxed tracking-tight italic">"Kesehatan mental bukanlah sebuah tujuan, melainkan sebuah proses perjalanan."</p>
                <p class="mt-8 text-sm md:text-base text-slate-400 font-medium tracking-wide">Cukup kenali apa yang kamu rasakan hari ini, lalu lanjutkan dengan tenang.</p>
            </div>
        </section>

    </div>
</div>

@endsection