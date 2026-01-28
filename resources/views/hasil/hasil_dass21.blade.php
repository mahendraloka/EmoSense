@extends('layouts.app')

@section('content')
{{-- BACKGROUND DECORATION --}}
<div class="fixed inset-0 -z-10 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
    <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
</div>

<div class="max-w-3xl mx-auto space-y-6 pb-20 pt-4 px-4">

    {{-- KARTU UTAMA --}}
    <div class="bg-white/80 backdrop-blur-xl shadow-2xl shadow-slate-200/60 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-12 border border-white relative overflow-hidden">
        
        {{-- HEADER HASIL --}}
        <div class="text-center space-y-3 relative z-10 mb-8">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-50 border border-sky-100 text-sky-600 text-[10px] font-black uppercase tracking-widest shadow-sm">
                📊 Hasil Analisis Emosional
            </div>
            <h2 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tight leading-tight">
                Laporan DASS-21 Kamu
            </h2>
            <p class="text-slate-500 text-xs md:text-sm font-medium flex items-center justify-center gap-2">
                <svg class="w-3 h-3 md:w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($hasil->tanggal_test)->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- PENJELASAN & ANJURAN UTAMA (Posisi Atas Sesuai Permintaan) --}}
        <div class="bg-amber-50/60 rounded-3xl border border-amber-100/50 p-5 md:p-8 mb-10">
            <div class="flex items-start gap-3 md:gap-4">
                <span class="text-xl md:text-2xl flex-shrink-0">⚠️</span>
                <p class="text-[11px] md:text-base text-amber-900/80 font-semibold leading-relaxed">
                    Hasil ini adalah <span class="text-amber-600 underline decoration-amber-300 underline-offset-2">skrining awal</span>, bukan diagnosis klinis resmi. Jika kondisi emosionalmu terasa berat atau mengganggu aktivitas sehari-hari, sangat disarankan untuk mencari bantuan profesional. Hanya tenaga ahli yang dapat memberikan penilaian menyeluruh.
                </p>
            </div>
        </div>

        {{-- KARTU DETAIL HASIL --}}
        <div class="space-y-6">
            @php
                $getTheme = function($kategori, $tingkat) {
                    $base = match($tingkat) {
                        'Normal'       => ['bg' => 'bg-blue-500',    'text' => 'text-blue-600',    'light' => 'bg-blue-50'],
                        'Ringan'       => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'light' => 'bg-emerald-50'],
                        'Sedang'       => ['bg' => 'bg-amber-500',   'text' => 'text-amber-600',   'light' => 'bg-amber-50'],
                        'Berat'        => ['bg' => 'bg-orange-600',  'text' => 'text-orange-700',  'light' => 'bg-orange-50'],
                        'Sangat Berat' => ['bg' => 'bg-red-600',     'text' => 'text-red-700',     'light' => 'bg-red-50'],
                        default        => ['bg' => 'bg-slate-400',   'text' => 'text-slate-500',   'light' => 'bg-slate-50'],
                    };

                    $emojis = [
                        'Depresi'   => ['Normal' => '😊', 'Ringan' => '🙂', 'Sedang' => '😔', 'Berat' => '☹️', 'Sangat Berat' => '😫'],
                        'Kecemasan' => ['Normal' => '😇', 'Ringan' => '🤨', 'Sedang' => '😟', 'Berat' => '😰', 'Sangat Berat' => '😱'],
                        'Stres'     => ['Normal' => '😌', 'Ringan' => '😐', 'Sedang' => '😑', 'Berat' => '😣', 'Sangat Berat' => '🤯'],
                    ];

                    $base['emoji'] = $emojis[$kategori][$tingkat] ?? '😶';
                    return $base;
                };

                $items = [
                    ['label' => 'Depresi', 'skor' => $hasil->skor_depresi, 'tingkat' => $hasil->tingkat_depresi, 'theme' => $getTheme('Depresi', $hasil->tingkat_depresi), 'saran' => $saranDepresi],
                    ['label' => 'Kecemasan', 'skor' => $hasil->skor_anxiety, 'tingkat' => $hasil->tingkat_anxiety, 'theme' => $getTheme('Kecemasan', $hasil->tingkat_anxiety), 'saran' => $saranAnxiety],
                    ['label' => 'Stres', 'skor' => $hasil->skor_stress, 'tingkat' => $hasil->tingkat_stress, 'theme' => $getTheme('Stres', $hasil->tingkat_stress), 'saran' => $saranStress],
                ];
            @endphp

            @foreach($items as $item)
            <div class="relative group">
                <div class="{{ $item['theme']['light'] }}/40 p-5 md:p-8 rounded-[2rem] border border-white group-hover:bg-white group-hover:shadow-xl transition-all duration-500">
                    <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                        <div class="flex items-center gap-4 md:min-w-[180px]">
                            <span class="text-4xl md:text-5xl transform group-hover:rotate-12 transition-transform duration-500">
                                {{ $item['theme']['emoji'] }}
                            </span>
                            <div>
                                <h4 class="text-[9px] md:text-[10px] font-black {{ $item['theme']['text'] }} uppercase tracking-[0.2em] mb-0.5">{{ $item['label'] }}</h4>
                                <p class="text-lg md:text-xl font-black text-slate-800 leading-none">{{ $item['tingkat'] }}</p>
                            </div>
                        </div>
                        <div class="flex-grow space-y-2 mt-2 md:mt-0">
                            <div class="flex justify-between items-end px-0.5">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Skor</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-base md:text-lg font-black text-slate-800">{{ $item['skor'] }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">/ 42</span>
                                </div>
                            </div>
                            <div class="w-full bg-slate-200/50 rounded-full h-2 md:h-3 overflow-hidden p-0.5">
                                <div class="{{ $item['theme']['bg'] }} h-full rounded-full transition-all duration-1000" style="width: {{ max(($item['skor'] / 42) * 100, 8) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100/80">
                        <div class="flex gap-3 items-start">
                            <div class="w-6 h-6 rounded-lg bg-white shadow-sm flex items-center justify-center flex-shrink-0 mt-0.5"><span class="text-xs">💡</span></div>
                            <p class="text-[11px] md:text-sm leading-relaxed text-slate-500 font-medium italic">"{{ $item['saran'] }}"</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- HOTLINE NASIONAL --}}
        <div class="mt-12">
            <div class="bg-sky-50/60 rounded-[2rem] border border-sky-100/50 p-6 md:p-8">
                <div class="flex items-start gap-4">
                    <span class="text-2xl md:text-3xl">📞</span>
                    <div class="space-y-3">
                        <h4 class="text-xs md:text-sm font-black text-sky-900 uppercase tracking-wider">Layanan Hotline Nasional</h4>
                        <p class="text-[11px] md:text-sm text-sky-800/80 leading-relaxed font-medium">
                            Dalam situasi krisis atau keadaan darurat, kamu bisa mengakses layanan bantuan gratis 24 jam di Indonesia:
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <a href="tel:119" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-sky-200 text-sky-600 font-bold text-[10px] shadow-sm hover:bg-sky-50 transition-colors">
                                📞 SEJIWA (119 ext. 8)
                            </a>
                            <a href="https://healing119.id" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-sky-200 text-sky-600 font-bold text-[10px] shadow-sm hover:bg-sky-50 transition-colors">
                                🌐 Healing119.id
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- AKSI --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-12">
            <a href="{{ route('mahasiswa.home') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white text-slate-600 font-black uppercase tracking-[0.15em] text-[10px] shadow-lg border border-slate-100 hover:bg-slate-50 transition-all active:scale-95 group order-2 sm:order-1">
                <svg class="w-3 h-3 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            <a href="{{ route('psikolog.list') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-black uppercase tracking-[0.15em] text-[10px] shadow-xl shadow-emerald-200/50 hover:opacity-90 transition-all active:scale-95 order-1 sm:order-2">
                <span>💬 Hubungi Psikolog</span>
            </a>
        </div>
    </div>
</div>
@endsection