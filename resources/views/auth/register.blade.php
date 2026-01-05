<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | EmoSense</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 antialiased">

<div class="flex min-h-screen overflow-hidden">

    {{-- LEFT SECTION: Decorative (Hidden on mobile) --}}
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-indigo-700 via-blue-800 to-slate-900 items-center justify-center p-12 relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-white max-w-lg">
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 inline-flex items-center gap-4 mb-12 border border-white/20 shadow-2xl">
                <div class="bg-white p-2 rounded-2xl">
                    <img src="{{ asset('img/logo.png') }}" alt="EmoSense" class="w-12 h-12">
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">EmoSense</h1>
                    <p class="text-xs text-blue-200 uppercase tracking-widest font-semibold">Join the community</p>
                </div>
            </div>

            <h2 class="text-4xl font-bold leading-tight mb-6 tracking-tight">
                Mulai perjalanan <br><span class="text-indigo-300 italic text-3xl font-light">mengenal dirimu sendiri.</span>
            </h2>

            <p class="text-lg text-blue-100/80 leading-relaxed mb-10 font-light">
                Dapatkan akses penuh ke perangkat monitoring kesehatan mental kami yang dirancang khusus untuk mahasiswa.
            </p>

            <ul class="space-y-6">
                <li class="flex items-start gap-4">
                    <div class="mt-1 w-6 h-6 bg-indigo-500/30 rounded-full flex items-center justify-center text-xs border border-white/20">✓</div>
                    <div>
                        <h4 class="font-bold text-white">Privasi Terjamin</h4>
                        <p class="text-sm text-blue-200/70">Data kesehatan mentalmu aman bersama kami.</p>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <div class="mt-1 w-6 h-6 bg-indigo-500/30 rounded-full flex items-center justify-center text-xs border border-white/20">✓</div>
                    <div>
                        <h4 class="font-bold text-white">Laporan Berkala</h4>
                        <p class="text-sm text-blue-200/70">Dapatkan tren emosimu setiap minggu/bulan.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    {{-- RIGHT SECTION: Form --}}
    <div class="flex w-full lg:w-1/2 items-center justify-center p-6 md:p-12 overflow-y-auto">
        <div class="w-full max-w-md my-8">
            {{-- Mobile Logo --}}
            <div class="flex lg:hidden justify-center mb-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" alt="EmoSense" class="w-10 h-10">
                    <span class="text-2xl font-bold text-slate-800">EmoSense</span>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 p-8 md:p-10 border border-slate-100">
                <header class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight mb-2">Registrasi Mahasiswa</h2>
                    <p class="text-slate-500 font-light text-sm">Lengkapi data untuk membuat akun baru</p>
                </header>

                @if (session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-xl text-sm mb-6 flex items-center gap-3">
                        <span>⚠️</span>
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" name="nama" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">NIM</label>
                            <input type="text" name="nim" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Fakultas</label>
                            <input type="text" name="fakultas" required placeholder="Contoh: Teknik"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Prodi</label>
                            <input type="text" name="prodi" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                            
                            <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none p-2">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644m17.832 0a1.012 1.012 0 0 1 0 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 0 1 1.563-3.046m4.01-4.22a9.956 9.956 0 0 1 3.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 0 1 1.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 0 1-1.563 3.046M9.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0Z" />
                                </svg>
                                <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-indigo-300 active:scale-[0.98] mt-4">
                        Daftar Akun
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-slate-500 text-sm">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:text-indigo-700 underline decoration-indigo-200 underline-offset-4">Masuk</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');
    const eyeSlashIcon = document.querySelector('#eyeSlashIcon');

    togglePassword.addEventListener('click', function () {
        // Toggle tipe input antara 'password' dan 'text'
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Ganti ikon mata
        eyeIcon.classList.toggle('hidden');
        eyeSlashIcon.classList.toggle('hidden');
    });
</script>
</body>
</html>