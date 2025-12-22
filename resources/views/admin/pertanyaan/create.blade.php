@extends('admin.layouts.master')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Tambah Instrumen</h1>
            <p class="text-gray-500 font-medium">Buat butir pertanyaan baru untuk kuesioner DASS-21.</p>
        </div>
        <a href="{{ route('admin.pertanyaan.index') }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors flex items-center group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        {{-- ID Form ditambahkan untuk seleksi JavaScript --}}
        <form id="pertanyaanForm" action="{{ route('admin.pertanyaan.store') }}" method="POST" class="divide-y divide-gray-50">
            @csrf
            
            <div class="p-8 md:p-12 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Urutan --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Urutan Item (1–21)</label>
                        <input type="number" name="urutan" min="1" max="21" value="{{ old('urutan') }}"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-bold text-lg text-blue-600"
                               placeholder="0" required>
                        @error('urutan') <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Kategori Gangguan</label>
                        <div class="relative">
                            <select name="kategori" required
                                    class="w-full appearance-none px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium cursor-pointer">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Stress" {{ old('kategori') == 'Stress' ? 'selected' : '' }}>Stress</option>
                                <option value="Anxiety" {{ old('kategori') == 'Anxiety' ? 'selected' : '' }}>Anxiety</option>
                                <option value="Depression" {{ old('kategori') == 'Depression' ? 'selected' : '' }}>Depression</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        @error('kategori') <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Teks Pertanyaan --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Bunyi Teks Pertanyaan</label>
                    <textarea name="teks_pertanyaan" rows="5" required
                              class="w-full px-6 py-5 bg-gray-50 border border-gray-200 rounded-[2rem] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium text-gray-700 leading-relaxed"
                              placeholder="Ketikkan bunyi pertanyaan di sini...">{{ old('teks_pertanyaan') }}</textarea>
                    @error('teks_pertanyaan') <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="px-8 py-10 bg-gray-50/50 flex flex-col md:flex-row justify-end items-center gap-4">
                <button type="button" onclick="confirmReset()" class="px-8 py-4 text-sm font-bold text-gray-400 hover:text-red-600 uppercase tracking-widest transition-colors">
                    Bersihkan Form
                </button>
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95 uppercase tracking-widest">
                    Simpan Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
/**
 * Konfirmasi sebelum menghapus semua isi form
 */
function confirmReset() {
    Swal.fire({
        title: 'Kosongkan input?',
        text: "Seluruh teks yang Anda ketik akan dihapus.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        borderRadius: '20px'
    }).then((result) => {
        if (result.isConfirmed) {
            resetFormPertanyaan();
        }
    })
}

/**
 * Fungsi Reset Form Manual (Mengosongkan old data)
 */
function resetFormPertanyaan() {
    const form = document.getElementById('pertanyaanForm');
    
    // Mengosongkan semua elemen input, select, dan textarea
    const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
    inputs.forEach(input => {
        input.value = "";
    });

    // Notifikasi Toast sukses
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Form dikosongkan',
        showConfirmButton: false,
        timer: 1500
    });
}
</script>
@endsection