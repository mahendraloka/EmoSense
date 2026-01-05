@extends('psikolog.layouts.master')

@section('title', 'Profil Psikolog')

@section('content')
<div class="max-w-4xl mx-auto pb-12 px-4 md:px-0">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Profil Saya</h1>
        <p class="text-gray-500 font-medium mt-1">
            Kelola informasi pribadi dan pengaturan keamanan akun profesional Anda.
        </p>
    </div>

    {{-- MAIN CARD --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
        
        <form id="profileForm"
              method="POST"
              action="{{ route('psikolog.profile.update') }}"
              enctype="multipart/form-data"
              class="divide-y divide-gray-50">
            @csrf
            @method('PUT')

            {{-- FOTO PROFIL SECTION --}}
            <div class="p-8 md:p-12 flex flex-col items-center bg-gray-50/50">
                <div class="relative group">
                    <div class="w-40 h-40 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gray-200 ring-4 ring-green-500/10">
                        <img id="fotoPreview"
                             src="{{ $psikolog->foto_profil
                                    ? asset('storage/' . $psikolog->foto_profil)
                                    : asset('images/default-user.png') }}"
                             class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    </div>
                    
                    <label class="absolute bottom-1 right-1 w-11 h-11 bg-green-600 text-white rounded-full flex items-center justify-center border-4 border-white cursor-pointer shadow-lg hover:bg-green-700 transition-all hover:scale-110 active:scale-95" title="Ganti Foto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <input type="file" name="foto_profil" class="hidden" accept="image/*" onchange="previewFoto(event)">
                    </label>
                </div>

                <div class="mt-4 text-center">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Foto Profil</h3>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG atau WEBP (Maks. 2MB)</p>
                </div>
            </div>

            {{-- INFORMASI PROFIL SECTION --}}
            <div class="p-8 md:p-12 space-y-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-6 bg-green-500 rounded-full"></div>
                    <h2 class="text-lg font-black text-gray-800 tracking-tight">Informasi Dasar</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <input type="text" name="nama"
                               value="{{ old('nama', $psikolog->nama) }}"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-medium text-gray-700">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Email (Akun)</label>
                        <div class="relative group">
                            <input type="email" value="{{ $psikolog->email }}" readonly
                                   class="w-full px-6 py-4 bg-gray-100 border border-gray-200 rounded-2xl text-gray-400 cursor-not-allowed font-medium">
                            <span class="absolute right-5 top-4 text-gray-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Nomor Telepon</label>
                        <input type="text" name="nomor_hp"
                               value="{{ old('nomor_hp', $psikolog->nomor_hp) }}"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-medium text-gray-700">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Spesialisasi</label>
                        <input type="text" name="spesialisasi"
                               value="{{ old('spesialisasi', $psikolog->spesialisasi) }}"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-medium text-gray-700">
                    </div>
                </div>
            </div>

            {{-- KEAMANAN SECTION --}}
            <div class="p-8 md:p-12 space-y-8 bg-gray-50/30">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-6 bg-red-500 rounded-full"></div>
                    <h2 class="text-lg font-black text-gray-800 tracking-tight">Keamanan Akun</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Password Baru --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                   placeholder="Min. 6 Karakter"
                                   class="w-full px-6 py-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-400 transition-all outline-none font-medium">
                            <button type="button" onclick="toggleVisibility('password', 'eyeNew')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 p-2 focus:outline-none">
                                <svg id="eyeNew" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-400 italic ml-1">*Kosongkan jika tidak ingin mengubah password</p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   class="w-full px-6 py-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-400 transition-all outline-none font-medium">
                            <button type="button" onclick="toggleVisibility('password_confirmation', 'eyeConfirm')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 p-2 focus:outline-none">
                                <svg id="eyeConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTION FOOTER --}}
            <div class="px-8 py-10 bg-white border-t border-gray-50 flex flex-col md:flex-row justify-end items-center gap-4">
                <button type="button"
                        onclick="confirmCancel()"
                        class="w-full md:w-auto px-8 py-4 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                    Batal
                </button>

                <button type="submit"
                        class="w-full md:w-auto px-12 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl shadow-xl shadow-green-600/20 transition-all active:scale-95 uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- SCRIPT SECTION --}}
<script>
// 1. Toggle Visibility Password
function toggleVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.add("text-green-600");
    } else {
        input.type = "password";
        icon.classList.remove("text-green-600");
    }
}

// 2. Validasi Client-side Password Match
document.getElementById('profileForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;

    if (password !== "" && password !== confirm) {
        e.preventDefault(); // Batalkan submit
        Swal.fire({
            icon: 'warning',
            title: 'Password Tidak Cocok',
            text: 'Konfirmasi password harus sama dengan password baru Anda.',
            borderRadius: '20px',
            confirmButtonColor: '#10b981'
        });
    }
});

// 3. Preview Foto
function previewFoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const preview = document.getElementById('fotoPreview');
        
        reader.onload = () => {
            preview.style.opacity = '0';
            setTimeout(() => {
                preview.src = reader.result;
                preview.style.opacity = '1';
            }, 200);
        };
        preview.style.transition = 'opacity 0.2s ease';
        reader.readAsDataURL(file);
    }
}

// 4. Konfirmasi Batal
function confirmCancel() {
    Swal.fire({
        title: 'Batalkan Perubahan?',
        text: 'Data yang telah Anda ketik akan dikembalikan ke semula.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Lanjutkan Edit',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#10b981',
        borderRadius: '20px'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('psikolog.dashboard') }}";
        }
    });
}
</script>

{{-- FLASH NOTIFICATIONS DARI SERVER --}}
@if (session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Update Berhasil',
    text: '{{ session('success') }}',
    confirmButtonColor: '#10b981',
    borderRadius: '20px'
});
</script>
@endif

@if ($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal Menyimpan',
    text: '{{ $errors->first() }}',
    confirmButtonColor: '#ef4444',
    borderRadius: '20px'
});
</script>
@endif

@endsection