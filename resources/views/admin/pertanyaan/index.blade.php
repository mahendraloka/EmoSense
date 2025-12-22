@extends('admin.layouts.master')

@section('content')
<div class="space-y-6 pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Instrumen DASS-21</h1>
            <p class="text-gray-500 font-medium mt-1">Kelola daftar pertanyaan penilaian mandiri kesehatan mental.</p>
        </div>

        @if($totalPertanyaan >= 21)
            {{-- Tombol Peringatan jika sudah 21 --}}
            <button onclick="alertFull()" 
            class="inline-flex items-center justify-center px-6 py-3 bg-gray-400 text-white font-bold rounded-2xl shadow-lg shadow-gray-400/20 transition-all cursor-not-allowed group">
            <span class="mr-2 transform group-hover:scale-110 transition-transform">🔒</span> Tambah Pertanyaan
            </button>
        @else
            {{-- Tombol Normal jika kurang dari 21 --}}
            <a href="{{ route('admin.pertanyaan.create') }}" 
            class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 group">
            <span class="mr-2 transform group-hover:rotate-90 transition-transform">➕</span> Tambah Pertanyaan
            </a>
        @endif
    </div>

    {{-- Search & Filter Card --}}
    <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
        <form method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" 
                       placeholder="Cari teks pertanyaan atau kategori..." 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-transparent rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
            </div>
            <button class="px-8 py-3 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all active:scale-95">
                Filter Data
            </button>
        </form>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center w-20">No</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Teks Pertanyaan</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pertanyaans as $p)
                    <tr class="group hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 text-gray-700 font-black text-sm group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                                {{ $p->urutan }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-gray-700 font-medium leading-relaxed max-w-md">
                                {{ $p->teks_pertanyaan }}
                            </p>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $colorMap = [
                                    'Depression' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    'Anxiety' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Stress' => 'bg-sky-50 text-sky-600 border-sky-100',
                                ];
                                $colorClass = $colorMap[$p->kategori] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold border {{ $colorClass }} uppercase tracking-tighter">
                                {{ $p->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('admin.pertanyaan.edit', $p->id_Pertanyaan) }}" 
                                   class="p-2.5 text-amber-500 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-xl transition-all shadow-sm"
                                   title="Edit Pertanyaan">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2l-6 6H9v-2z"/></svg>
                                </a>
                                <form action="{{ route('admin.pertanyaan.destroy', $p->id_Pertanyaan) }}" 
                                      method="POST" 
                                      class="form-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="p-2.5 text-red-500 bg-red-50 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm"
                                            title="Hapus Pertanyaan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M9 7V4h6v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-50 p-6 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Data tidak ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-4">
        {{ $pertanyaans->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Pertanyaan?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

<script>
    function alertFull() {
        Swal.fire({
            title: 'Batas Maksimum Tercapai',
            text: 'Instrumen DASS-21 telah memiliki 21 pertanyaan. Standar kuesioner ini tidak boleh lebih dari 21 item.',
            icon: 'info',
            confirmButtonColor: '#2563EB',
            confirmButtonText: 'Saya Mengerti',
            borderRadius: '20px'
        });
    }
</script>
@endsection
