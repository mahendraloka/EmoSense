@extends('layouts.app')

@section('content')
{{-- BACKGROUND DECORATION (Konsisten dengan halaman lain) --}}
<div class="fixed inset-0 -z-10 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
    <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
</div>

<div class="max-w-6xl mx-auto px-4 pb-20 pt-4">

    {{-- HEADER --}}
    <div class="text-center mb-16 space-y-4">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/80 border border-sky-100 text-sky-600 text-[10px] font-black uppercase tracking-widest shadow-sm backdrop-blur-md">
            <span>🤝</span> Professional Support
        </div>
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-800 tracking-tight leading-tight">
            Dampingi Langkahmu Bersama <br class="hidden md:block"> 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-indigo-600">Psikolog Terpercaya</span>
        </h2>
        <p class="text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
            Pilih tenaga profesional yang siap mendengarkan dan membantumu memahami diri lebih dalam di ruang yang aman dan rahasia.
        </p>
    </div>

    {{-- LIST PSIKOLOG --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
        @foreach ($psikolog as $item)
        <div class="group relative bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-8 text-center border border-white shadow-xl shadow-slate-200/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl overflow-hidden">
            
            {{-- Decorative Accent --}}
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-sky-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

            {{-- FOTO --}}
            <div class="relative mb-6 inline-block">
                <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden ring-4 ring-white shadow-xl transition-transform duration-500 group-hover:scale-105 group-hover:rotate-2">
                    <img
                        src="{{ $item->foto_profil ? asset('storage/' . $item->foto_profil) : asset('images/default-user.png') }}"
                        alt="{{ $item->nama }}"
                        class="w-full h-full object-cover">
                </div>
                
                {{-- Verified Badge --}}
                <div class="absolute -bottom-2 right-1/2 translate-x-1/2 flex items-center gap-1.5 bg-emerald-500 text-white text-[9px] font-black uppercase tracking-wider px-4 py-1.5 rounded-full shadow-lg border-2 border-white">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Verified
                </div>
            </div>

            {{-- INFORMASI --}}
            <div class="space-y-2 relative z-10">
                <h3 class="text-xl font-black text-slate-800 tracking-tight group-hover:text-sky-600 transition-colors">
                    {{ $item->nama }}
                </h3>
                <div class="flex flex-col items-center">
                    <span class="text-xs font-bold text-sky-500 uppercase tracking-[0.2em] mb-1">
                        {{ $item->spesialisasi }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-[10px] text-slate-400 font-bold bg-slate-50 px-3 py-1 rounded-lg border border-slate-100 uppercase tracking-tighter">
                        STR: {{ $item->nomor_str }}
                    </span>
                </div>
            </div>

            {{-- CTA BUTTON DENGAN TEMPLATE PESAN --}}
            <div class="mt-8 relative z-10">
                @php
                    // Template pesan pembuka
                    $pesan = "Halo Psikolog " . $item->nama . ", saya mahasiswa pengguna EmoSense. Saya ingin berkonsultasi mengenai hasil Self Assessment saya. Apakah Bapak/Ibu memiliki waktu luang?";
                    $encodedPesan = rawurlencode($pesan);
                    $nomorWa = preg_replace('/[^0-9]/', '', $item->nomor_hp);
                    
                    // Memastikan format nomor HP diawali dengan 62 (standar internasional WA)
                    if (str_starts_with($nomorWa, '0')) {
                        $nomorWa = '62' . substr($nomorWa, 1);
                    }
                @endphp

                <a href="https://wa.me/{{ $nomorWa }}?text={{ $encodedPesan }}"
                target="_blank"
                class="inline-flex items-center justify-center gap-3 w-full rounded-2xl px-6 py-4 bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-emerald-600 hover:shadow-emerald-200 transition-all duration-300 active:scale-95 group/btn">
                    
                    <svg class="w-5 h-5 transition-transform group-hover/btn:scale-110" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.67-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    Konsultasi Sekarang
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- FOOTER INFO --}}
    <div class="mt-20 text-center max-w-xl mx-auto bg-white/40 backdrop-blur-md rounded-3xl p-8 border border-white/60">
        <p class="text-xs text-slate-400 font-medium leading-relaxed italic">
            "Mengambil bantuan profesional bukanlah tanda kelemahan, melainkan tanda keberanian untuk memprioritaskan diri."
        </p>
    </div>

</div>
@endsection