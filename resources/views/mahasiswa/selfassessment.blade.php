@extends('layouts.app')

@section('content')
{{-- GLOBAL WRAPPER DENGAN BACKGROUND DEKORATIF (Konsisten dengan Home & Mood Tracker) --}}
<div class="relative overflow-hidden min-h-screen">
    {{-- BACKGROUND DECORATION --}}
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
        <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
    </div>

    <div class="flex flex-col items-center space-y-10 pb-20 pt-4">

        {{-- HEADER --}}
        <div class="w-full max-w-3xl px-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white text-2xl shadow-lg shadow-sky-200 transform -rotate-3">
                        🧠
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight leading-none">Self Assessment</h1>
                        <p class="text-sm text-slate-500 font-medium mt-2">Pahami kondisi emosionalmu saat ini.</p>
                    </div>
                </div>
                <a href="{{ route('mahasiswa.home') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-white/80 backdrop-blur-md text-slate-600 font-bold shadow-sm border border-white hover:bg-white transition-all active:scale-95 text-xs uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Beranda
                </a>
            </div>

            {{-- PETUNJUK PENGISIAN --}}
            <div class="relative rounded-[2.5rem] p-8 md:p-10 bg-white/80 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 overflow-hidden group">
                {{-- AKSEN VISUAL --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-sky-100 rounded-full blur-3xl group-hover:bg-sky-200 transition-colors duration-500"></div>
                
                <div class="relative">
                    <h3 class="font-black text-slate-800 text-lg mb-4 flex items-center gap-2 uppercase tracking-widest text-sm">
                        <span class="w-2 h-2 bg-sky-500 rounded-full animate-pulse"></span>
                        Tentang DASS-21
                    </h3>
                    
                    <div class="space-y-4 text-slate-600 leading-relaxed font-medium">
                        <p class="text-sm md:text-base">
                            <strong class="text-sky-600">Depression Anxiety Stress Scale-21 (DASS-21)</strong> 
                            adalah instrumen untuk menggambarkan kondisi emosional berdasarkan pengalamanmu selama 
                            <span class="px-2 py-0.5 bg-sky-100 text-sky-700 rounded-lg font-bold italic underline decoration-sky-300">7 hari terakhir</span>.
                        </p>
                        
                        <p class="text-sm md:text-base">
                            Instrumen ini mencakup aspek <span class="font-bold text-slate-800">depresi, kecemasan,</span> dan <span class="font-bold text-slate-800">stres</span>. Hasilnya digunakan sebagai 
                            <em class="text-indigo-600 font-semibold not-italic">alat bantu refleksi diri</em>, bukan diagnosis klinis resmi.
                        </p>

                        <div class="pt-2 flex items-start gap-3 text-xs text-slate-400 italic">
                            <span>💡</span>
                            <p>Tidak ada jawaban benar atau salah. Isilah sesuai dengan kondisi yang sebenarnya kamu alami agar hasilnya akurat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM ASSESSMENT --}}
        <form action="{{ route('selfassessment.store') }}" method="POST" id="assessmentForm"
              class="w-full max-w-3xl space-y-6 px-4">
            @csrf

            @foreach($questions as $index => $question)
            <div class="bg-white/90 backdrop-blur rounded-[2rem] p-7 md:p-10 shadow-xl shadow-slate-200/40 border border-white hover:border-sky-100 transition-all group">
                
                <div class="flex gap-4 mb-8">
                    <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center font-black text-xs group-hover:bg-sky-500 group-hover:text-white transition-colors">
                        {{ $question->urutan }}
                    </span>
                    <p class="font-bold text-slate-800 text-lg md:text-xl leading-relaxed tracking-tight text-left">
                        {{ $question->teks_pertanyaan }}
                    </p>
                </div>

                {{-- GRID PILIHAN JAWABAN (Mobile: Vertikal, Desktop: Grid 4) --}}
                <div class="flex flex-col sm:grid sm:grid-cols-4 gap-3 md:gap-4">
                    @for($i = 0; $i <= 3; $i++)
                    @php
                        $label = match($i) {
                            0 => 'Tidak Pernah',
                            1 => 'Kadang-kadang',
                            2 => 'Sering',
                            3 => 'Hampir Selalu'
                        };
                    @endphp
                    <label class="relative flex sm:flex-col items-center gap-3 sm:gap-0 cursor-pointer p-4 md:p-5 rounded-2xl bg-slate-50 border-2 border-transparent transition-all hover:bg-white hover:border-sky-200 group/label">
                        
                        <input type="radio" 
                            name="answers[{{ $question->id_Pertanyaan }}]" 
                            value="{{ $i }}" required
                            class="peer absolute opacity-0">

                        {{-- Custom Radio Circle --}}
                        <div class="w-6 h-6 border-2 border-slate-300 rounded-full flex items-center justify-center peer-checked:border-sky-500 peer-checked:bg-sky-500 transition-all sm:mb-3 flex-shrink-0">
                            <div class="w-2 h-2 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                        </div>

                        <span class="text-xs md:text-sm font-bold text-slate-500 peer-checked:text-sky-600 transition-colors text-left sm:text-center leading-tight">
                            {{ $label }}
                        </span>

                        {{-- Hover/Active Overlay --}}
                        <div class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-sky-500 pointer-events-none"></div>
                    </label>
                    @endfor
                </div>
            </div>
            @endforeach

            {{-- SUBMIT BUTTON --}}
            <div class="flex justify-center pt-8 pb-10 text-left">
                <button type="submit" 
                    class="group relative inline-flex items-center justify-center gap-3 bg-gradient-to-r from-sky-600 to-indigo-600 text-white px-16 py-5 rounded-[1.5rem] font-black uppercase tracking-[0.2em] text-sm shadow-2xl shadow-sky-200 hover:opacity-90 transition-all active:scale-95 w-full md:w-auto">
                    <span>Kirim Jawaban</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('assessmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Logika konfirmasi SweetAlert2
        Swal.fire({
            title: 'Selesai Mengisi?',
            text: "Pastikan jawabanmu sudah sesuai dengan pengalamanmu selama 7 hari terakhir.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0ea5e9', // Warna Sky-600
            cancelButtonColor: '#94a3b8',  // Warna Slate-400
            confirmButtonText: 'Ya, Kirim Sekarang!',
            cancelButtonText: 'Cek Lagi',
            borderRadius: '24px',
            background: '#ffffff',
            customClass: {
                title: 'font-black tracking-tight text-slate-800',
                htmlContainer: 'font-medium text-slate-500',
                confirmButton: 'rounded-2xl px-6 py-3 font-bold uppercase tracking-widest text-xs',
                cancelButton: 'rounded-2xl px-6 py-3 font-bold uppercase tracking-widest text-xs'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading sebentar sebelum submit (opsional untuk estetika)
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Jawabanmu sedang kami hitung.',
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    borderRadius: '24px',
                    showConfirmButton: false,
                }).then(() => {
                    this.submit();
                });
            }
        });
    });
</script>
@endsection