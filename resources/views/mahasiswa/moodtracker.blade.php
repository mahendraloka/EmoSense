@extends('layouts.app')

@section('content')
@php
$emojis = [
    1 => ['emoji' => '😢', 'label' => 'Sangat Sedih', 'color' => 'rose'],
    2 => ['emoji' => '🙁', 'label' => 'Sedih', 'color' => 'orange'],
    3 => ['emoji' => '😐', 'label' => 'Biasa Saja', 'color' => 'gray'],
    4 => ['emoji' => '🙂', 'label' => 'Senang', 'color' => 'emerald'],
    5 => ['emoji' => '😄', 'label' => 'Sangat Senang', 'color' => 'green'],
];
@endphp

<div class="relative overflow-hidden min-h-screen">
    {{-- FIXED BACKGROUND DECORATION (Identik dengan Home) --}}
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
        <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-4xl mx-auto space-y-8 pb-12 pt-4">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-2">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white text-2xl shadow-lg shadow-sky-200 transform -rotate-3">
                    📅
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Mood Tracker</h1>
                    <p class="text-sm text-slate-500 font-medium">Rekam perjalanan emosimu hari ini.</p>
                </div>
            </div>
            <a href="{{ route('mahasiswa.home') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-white/80 backdrop-blur-md text-slate-600 font-bold shadow-sm border border-white hover:bg-white transition-all active:scale-95 text-xs uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Beranda
            </a>
        </div>

        {{-- FORM INPUT --}}
        <form id="moodForm" action="{{ route('moodtracker.store') }}" method="POST"
              class="bg-white/80 backdrop-blur-xl shadow-2xl shadow-slate-200/60 rounded-[2.5rem] p-6 md:p-10 space-y-10 border border-white relative overflow-hidden">
            @csrf
            
            <div class="text-center space-y-2">
                <h2 class="font-black text-slate-800 text-2xl tracking-tight">Bagaimana perasaanmu?</h2>
                <div class="w-12 h-1.5 bg-sky-200 mx-auto rounded-full"></div>
            </div>

            {{-- EMOJI SELECTOR --}}
            <div class="grid grid-cols-5 gap-3 md:gap-6 py-2">
                @foreach($emojis as $value => $data)
                    <label class="group flex flex-col items-center cursor-pointer">
                        <input type="radio" name="tingkat_mood" value="{{ $value }}" class="peer hidden" required>
                        <div class="w-full aspect-square flex items-center justify-center text-4xl md:text-6xl rounded-[2rem] bg-slate-50/50 border-2 border-transparent transition-all duration-500 
                                    group-hover:scale-105 group-hover:bg-white
                                    peer-checked:bg-white peer-checked:border-sky-500 peer-checked:shadow-2xl peer-checked:shadow-sky-100 peer-checked:-translate-y-2">
                            {{ $data['emoji'] }}
                        </div>
                        <span class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] mt-4 text-slate-400 peer-checked:text-sky-600 transition-colors text-center leading-tight">
                            {{ $data['label'] }}
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Catatan Refleksi Diri</label>
                <textarea name="catatan_harian" rows="4"
                          placeholder="Apa yang ada di pikiranmu hari ini? (Boleh dikosongkan)"
                          class="w-full bg-slate-50/50 border border-slate-100 rounded-[2rem] p-6 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 focus:bg-white transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300"></textarea>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-sky-600 to-indigo-600 text-white py-5 rounded-[1.5rem] font-black uppercase tracking-[0.2em] hover:opacity-90 transition-all shadow-xl shadow-sky-200 active:scale-[0.98]">
                Catat Mood Hari Ini
            </button>
        </form>

    {{-- GRAFIK MOOD (EMOJI AXIS) --}}
    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] p-6 md:p-10 border border-slate-100">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-1.5 h-6 bg-sky-500 rounded-full"></div>
            <h2 class="font-black text-slate-800 text-lg tracking-tight uppercase tracking-widest text-sm">Tren Emosi Kamu</h2>
        </div>
        <div class="h-[300px] md:h-[350px]">
            <canvas id="moodChart"></canvas>
        </div>
    </div>

    {{-- RIWAYAT --}}
    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] p-6 md:p-10 border border-slate-100 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-slate-800 text-lg tracking-tight uppercase tracking-widest text-sm">Riwayat Catatan</h2>
            <span class="px-3 py-1 bg-slate-100 text-[10px] font-black text-slate-400 rounded-lg">TOTAL: {{ $history->count() }}</span>
        </div>

        <div class="space-y-4">
            @forelse($history as $item)
                @php 
                    $moodInt = intval($item->tingkat_mood); 
                    $m = $emojis[$moodInt] ?? ['emoji' => '😶', 'label' => 'Unknown', 'color' => 'gray'];
                @endphp

                <div x-data="{ edit: false }" class="group relative bg-slate-50/50 rounded-3xl p-5 md:p-6 border border-transparent hover:border-slate-200 hover:bg-white transition-all duration-300">
                    <div class="flex gap-4 md:gap-6">
                        <div class="flex flex-col items-center justify-center flex-shrink-0">
                            <span class="text-4xl filter drop-shadow-sm group-hover:scale-110 transition-transform">{{ $m['emoji'] }}</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y • H:i') }} WIB
                                </p>
                                {{-- ACTIONS --}}
                                <div class="flex gap-4 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                    <button @click="edit = true" class="flex items-center gap-1 text-[11px] font-black text-sky-600 uppercase hover:underline">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        Edit
                                    </button>
                                    <button @click="confirmDelete('{{ route('moodtracker.destroy', $item->id_Mood) }}')" class="flex items-center gap-1 text-[11px] font-black text-rose-600 uppercase hover:underline">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            {{-- VIEW STATE --}}
                            <div x-show="!edit" class="space-y-1">
                                <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ $m['label'] }}</p>
                                <p class="text-sm text-slate-500 leading-relaxed italic break-words [overflow-wrap:anywhere]">
                                    "{{ $item->catatan_harian ?: 'Tanpa catatan naratif.' }}"
                                </p>
                            </div>

                            {{-- EDIT STATE --}}
                            <div x-show="edit" x-cloak class="mt-3">
                                <form method="POST" action="{{ route('moodtracker.update', $item->id_Mood) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <select name="tingkat_mood" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500/20 outline-none">
                                        @foreach($emojis as $v => $e)
                                            <option value="{{ $v }}" @selected($v == $moodInt)>{{ $e['emoji'] }} {{ $e['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <textarea name="catatan_harian" rows="2" class="w-full bg-white border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-sky-500/20 outline-none">{{ $item->catatan_harian }}</textarea>
                                    <div class="flex gap-3">
                                        <button class="px-4 py-2 bg-sky-600 text-white rounded-lg text-[10px] font-black uppercase tracking-widest">Update</button>
                                        <button type="button" @click="edit = false" class="px-4 py-2 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada riwayat mood</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* ===============================
        SWEETALERT CONFIRMATIONS
    ================================ */
    
    // Konfirmasi Simpan Mood Baru
    document.getElementById('moodForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan aktivitas?',
            text: "Data mood kamu akan tercatat dalam jurnal harian.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            borderRadius: '24px'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // Konfirmasi Hapus
    function confirmDelete(url) {
        Swal.fire({
            title: 'Hapus riwayat?',
            text: "Catatan mood ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus!',
            borderRadius: '24px'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    /* ===============================
        MOOD CHART (EMOJI AXIS)
    ================================ */
    
    document.addEventListener('DOMContentLoaded', () => {
        const labels = @json($chartLabels ?? []);
        const data = @json($chartValues ?? []);
        const moodEmojiMap = { 5: '😄', 4: '🙂', 3: '😐', 2: '🙁', 1: '😢' };

        if (!labels.length || !data.length) return;

        new Chart(document.getElementById('moodChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data,
                    fill: true,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.05)',
                    tension: 0.45,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 3,
                    pointHoverRadius: 9
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ' Kondisi: ' + (moodEmojiMap[ctx.parsed.y] || ctx.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 1,
                        max: 5,
                        grid: { borderDash: [5, 5], color: '#f1f5f9', drawBorder: false },
                        ticks: {
                            stepSize: 1,
                            font: { size: window.innerWidth < 768 ? 16 : 22 },
                            callback: value => moodEmojiMap[value] || value
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' }
                    }
                }
            }
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false,
            borderRadius: '24px'
        });
    @endif
</script>
@endsection