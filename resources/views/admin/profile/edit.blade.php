@extends('admin.layouts.master')

@section('title', 'Profil Admin')

@section('content')
<div class="max-w-4xl mx-auto pb-12 px-4 md:px-0">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Profil Admin</h1>
        <p class="text-sm md:text-base text-slate-500 font-medium mt-1">
            Kelola informasi akun administrator EmoSense.
        </p>
    </div>

    {{-- MAIN CARD --}}
    <div class="bg-white rounded-3xl md:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" class="divide-y divide-slate-50">
            @csrf
            @method('PUT')

            {{-- SECTION: INFORMASI AKUN --}}
            <div class="p-6 md:p-12 space-y-8">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-6 bg-blue-600 rounded-full"></div>
                    <h2 class="text-lg font-black text-slate-800 tracking-tight">Informasi Akun</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $admin->nama) }}" 
                               class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none font-medium transition-all">
                        @error('nama') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email (Read-Only) --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Email (Akun Utama)</label>
                        <div class="relative group">
                            <input type="email" value="{{ $admin->email }}" readonly 
                                   class="w-full px-6 py-4 bg-slate-100 border border-slate-200 rounded-2xl text-slate-400 cursor-not-allowed font-medium outline-none"
                                   title="Email tidak dapat diubah">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                        <p class="text-[10px] text-slate-400 italic ml-1">*Hubungi IT Support jika ingin mengganti email</p>
                    </div>
                </div>
            </div>

            {{-- SECTION: KEAMANAN / PASSWORD --}}
            <div class="p-6 md:p-12 space-y-8 bg-slate-50/30">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-lg font-black text-slate-800 tracking-tight">Ubah Password</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    {{-- Password Baru --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter"
                                   class="w-full px-6 py-4 bg-white border @error('password') border-red-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 outline-none font-medium transition-all">
                            <button type="button" onclick="toggleVisibility('password', 'eyeNew')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-2 focus:outline-none">
                                <svg id="eyeNew" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 italic ml-1">*Kosongkan jika tidak ingin mengubah</p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru"
                                   class="w-full px-6 py-4 bg-white border @error('password') border-red-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 outline-none font-medium transition-all">
                            <button type="button" onclick="toggleVisibility('password_confirmation', 'eyeConfirm')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-2 focus:outline-none">
                                <svg id="eyeConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" />
                                </svg>
                            </button>
                        </div>
                        @error('password') 
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ACTION FOOTER --}}
            <div class="px-6 md:px-12 py-8 bg-white border-t border-slate-50 flex flex-col md:flex-row justify-end items-center gap-4">
                <button type="button" 
                        onclick="confirmCancel()"
                        class="w-full md:w-auto text-center px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest order-2 md:order-1">
                    Batal
                </button>
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95 uppercase tracking-widest order-1 md:order-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // 1. Fungsi Toggle Password
    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.add("text-blue-600");
        } else {
            input.type = "password";
            icon.classList.remove("text-blue-600");
        }
    }

    // 2. Validasi Client-side sebelum submit
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;

        if (password !== "" && password !== confirm) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Password Tidak Cocok',
                text: 'Pastikan konfirmasi password sama dengan password baru Anda.',
                borderRadius: '20px',
                confirmButtonColor: '#f59e0b'
            });
        }
    });

    // 3. Fungsi Konfirmasi Batal 
    function confirmCancel() {
        Swal.fire({
            title: 'Batalkan Perubahan?',
            text: 'Data yang telah Anda ketik akan dikembalikan ke semula.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Lanjutkan Edit',
            confirmButtonColor: '#ef4444', // red-500
            cancelButtonColor: '#2563eb', // blue-600
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.dashboard') }}";
            }
        });
    }
</script>

{{-- Notifikasi SweetAlert dari Server --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        borderRadius: '20px',
        confirmButtonColor: '#2563eb'
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Memperbarui',
        text: '{{ $errors->first() }}',
        borderRadius: '20px',
        confirmButtonColor: '#ef4444'
    });
</script>
@endif

@endsection