@extends('psikolog.layouts.master')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6 pb-12">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Data Mahasiswa</h1>
            <p class="text-gray-500 font-medium">Pantau kondisi psikologis seluruh mahasiswa secara real-time.</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest text-xs">Total: {{ $mahasiswa->total() }}</span>
        </div>
    </div>

    {{-- SEARCH BOX --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-2">
        <form method="GET" action="{{ route('psikolog.mahasiswa.index') }}" class="flex flex-col md:flex-row gap-2">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, NIM, fakultas, atau prodi..." 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border-transparent rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-medium">
            </div>
            <div class="flex gap-2 p-1">
                <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition-all active:scale-95">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('psikolog.mahasiswa.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all text-center flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center w-16">No</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Mahasiswa</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Mood Terakhir</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Skor DASS</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status Risiko</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mahasiswa as $index => $mhs)
                    <tr class="group hover:bg-green-50/30 transition-colors">
                        <td class="px-6 py-5 text-center font-bold text-gray-400 text-sm">
                            {{ $mahasiswa->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-black text-xs uppercase shadow-sm">
                                    {{ substr($mhs->nama, 0, 2) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 truncate max-w-[180px] group-hover:text-green-600 transition-colors">{{ $mhs->nama }}</p>
                                    <p class="text-xs font-medium text-gray-400">NIM: {{ $mhs->nim }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($mhs->moodTerakhir)
                                @php
                                    // Map berdasarkan tingkat_mood (asumsi 1: Sangat Sedih, 5: Sangat Senang)
                                    // Sesuaikan key di bawah dengan isi kolom 'tingkat_mood' di database Anda
                                    $moodData = [
                                        'Sangat Senang' => ['emoji' => '😄', 'color' => 'text-green-500', 'bg' => 'bg-green-50'],
                                        'Senang'        => ['emoji' => '🙂', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
                                        'Biasa Saja'    => ['emoji' => '😐', 'color' => 'text-slate-500', 'bg' => 'bg-slate-50'],
                                        'Sedih'         => ['emoji' => '🙁', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50'],
                                        'Sangat Sedih'  => ['emoji' => '😢', 'color' => 'text-rose-500', 'bg' => 'bg-rose-50'],
                                    ];
                        
                                    $currentMood = $moodData[$mhs->moodTerakhir->tingkat_mood] ?? null;
                                @endphp
                        
                                @if($currentMood)
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl {{ $currentMood['bg'] }} transition-transform group-hover:scale-110 shadow-sm border border-white" 
                                         title="{{ $mhs->moodTerakhir->tingkat_mood }}">
                                        <span class="text-2xl">{{ $currentMood['emoji'] }}</span>
                                    </div>
                                    <p class="text-[9px] font-black uppercase tracking-tighter mt-1 {{ $currentMood['color'] }} opacity-0 group-hover:opacity-100 transition-opacity">
                                        {{ $mhs->moodTerakhir->tingkat_mood }}
                                    </p>
                                @else
                                    {{-- Jika database menyimpan angka (1-5) --}}
                                    @php
                                        $moodIcons = [
                                            5 => '😄', 
                                            4 => '🙂', 
                                            3 => '😐', 
                                            2 => '🙁', 
                                            1 => '😢'
                                        ];
                                        $emoji = $moodIcons[$mhs->moodTerakhir->tingkat_mood] ?? '😶';
                                    @endphp
                                    <span class="text-2xl" title="Skor: {{ $mhs->moodTerakhir->tingkat_mood }}">{{ $emoji }}</span>
                                @endif
                            @else
                                <div class="flex flex-col items-center opacity-20">
                                    <span class="text-xl">😶</span>
                                    <span class="text-[9px] font-bold uppercase mt-1">Kosong</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center font-black text-gray-700">
                            @if($mhs->dassTerakhir)
                                {{ $mhs->dassTerakhir->skor_depresi + $mhs->dassTerakhir->skor_anxiety + $mhs->dassTerakhir->skor_stress }}
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php $dass = $mhs->dassTerakhir; @endphp
                            @if(!$dass)
                                <span class="text-[10px] font-bold text-gray-300 uppercase italic">Belum Mengisi</span>
                            @elseif(in_array($dass->tingkat_depresi, ['Berat','Sangat Berat']) || in_array($dass->tingkat_anxiety, ['Berat','Sangat Berat']) || in_array($dass->tingkat_stress, ['Berat','Sangat Berat']))
                                <span class="px-4 py-1.5 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase border border-rose-100 shadow-sm animate-pulse">Risiko Tinggi</span>
                            @elseif(in_array($dass->tingkat_depresi, ['Sedang']) || in_array($dass->tingkat_anxiety, ['Sedang']) || in_array($dass->tingkat_stress, ['Sedang']))
                                <span class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase border border-amber-100 shadow-sm">Sedang</span>
                            @else
                                <span class="px-4 py-1.5 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase border border-green-100 shadow-sm">Normal</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <a href="{{ route('psikolog.mahasiswa.detail', $mhs->id_Mahasiswa) }}"
                               class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm group/btn">
                                <svg class="w-5 h-5 transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Data mahasiswa tidak ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-4">
        {{ $mahasiswa->links() }}
    </div>
</div>
@endsection