@extends('admin.layouts.master')

@section('title', 'Tambah ' . ucfirst($type))

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Tambah {{ ucfirst($type) }}</h1>
            <p class="text-gray-500 font-medium mt-1">Daftarkan akun {{ $type }} baru ke sistem EmoSense.</p>
        </div>
        <a href="{{ route('admin.users.index', ['type' => $type]) }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition flex items-center group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        {{-- ID form ditambahkan agar pemanggilan di JS lebih presisi --}}
        <form id="userForm" action="{{ route('admin.users.store', $type) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-50">
            @csrf
            
            <div class="p-8 md:p-12 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium" placeholder="Masukkan nama...">
                        @error('nama') <p class="text-red-600 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium" placeholder="email@domain.com">
                        @error('email') <p class="text-red-600 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p> @enderror
                    </div>

                    {{-- Mahasiswa Fields --}}
                    @if ($type === 'mahasiswa')
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">NIM</label>
                            <input type="text" name="nim" value="{{ old('nim') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                            @error('nim') <p class="text-red-600 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Fakultas</label>
                            <input type="text" name="fakultas" value="{{ old('fakultas') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Program Studi</label>
                            <input type="text" name="prodi" value="{{ old('prodi') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                        </div>
                    @endif

                    {{-- Psikolog Fields --}}
                    @if ($type === 'psikolog')
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Nomor HP</label>
                            <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Nomor STR</label>
                            <input type="text" name="nomor_str" value="{{ old('nomor_str') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Spesialisasi</label>
                            <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                        </div>
                        
                        {{-- Foto Profil UI --}}
                        <div class="md:col-span-2 bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100 mt-4">
                            <label class="block text-sm font-bold text-blue-800 uppercase tracking-widest mb-4 ml-1 text-center md:text-left">Upload Foto Profil</label>
                            <div class="flex flex-col md:flex-row items-center gap-8">
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gray-100">
                                        <img id="fotoPreview" src="{{ asset('images/default-user.png') }}" class="w-full h-full object-cover">
                                    </div>
                                    <label for="foto_profil" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center border-4 border-white cursor-pointer hover:bg-blue-700 transition-all shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </label>
                                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden" onchange="previewFoto(event)">
                                </div>
                                <div class="flex-1 text-center md:text-left">
                                    <p class="text-sm font-bold text-blue-900 italic">Pratinjau Foto</p>
                                    <p class="text-xs text-blue-600 mt-1 font-medium">JPG/PNG maksimal 2MB. Gunakan foto terbaru.</p>
                                    @error('foto_profil') <p class="text-red-600 text-xs font-bold mt-1 italic">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="px-8 py-10 bg-gray-50/50 flex flex-col md:flex-row justify-end items-center gap-4">
                <button type="button" onclick="confirmReset()" class="px-8 py-4 text-sm font-bold text-gray-400 hover:text-red-600 uppercase transition-colors tracking-widest">
                    Kosongkan Form
                </button>
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95 uppercase tracking-widest">
                    Daftarkan {{ ucfirst($type) }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
/**
 * Fungsi untuk Preview Foto
 */
function previewFoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('fotoPreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(file);
    }
}

/**
 * Fungsi Konfirmasi sebelum Reset
 */
function confirmReset() {
    Swal.fire({
        title: 'Kosongkan form?',
        text: "Semua data yang telah diisi akan dihapus.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            resetMyForm();
        }
    })
}

/**
 * Fungsi Inti Reset Form
 */
function resetMyForm() {
    const form = document.getElementById('userForm');
    
    // Reset input teks manual untuk mengatasi masalah data 'old()' dari server
    const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
    inputs.forEach(input => {
        input.value = "";
    });

    // Reset Pratinjau Gambar ke default
    const preview = document.getElementById('fotoPreview');
    if (preview) {
        preview.src = "{{ asset('images/default-user.png') }}"; 
    }

    // Notifikasi Toast
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Form berhasil dikosongkan',
        showConfirmButton: false,
        timer: 1500
    });
}
</script>
@endsection