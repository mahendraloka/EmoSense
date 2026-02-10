<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MoodTrackerController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SelfAssessmentController;
use App\Http\Controllers\PsikologController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ArtikelAdminController;
use App\Http\Controllers\Admin\PertanyaanDASS21Controller;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Psikolog\ProfileController as PsikologProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;


// Redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'registerProcess'])->name('register.process');


//MAHASISWA
Route::middleware(['auth:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/home', function () {
        return view('mahasiswa.home');
    })->name('mahasiswa.home');

    Route::post('/logout/mahasiswa', function (Illuminate\Http\Request $request) {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout.mahasiswa');
//Fitur Mahasiswa
    //selfassessment
    Route::get('/selfassessment', [SelfAssessmentController::class, 'index'])->name('selfassessment.index');
    Route::post('/selfassessment', [SelfAssessmentController::class, 'store'])->name('selfassessment.store');
    Route::get('/selfassessment/result/{id}', [SelfAssessmentController::class, 'result'])->name('selfassessment.result');
    Route::get('/psikolog', [PsikologController::class, 'index'])->name('psikolog.list');
    //moodtracker
    Route::get('/mahasiswa/moodtracker', [MoodTrackerController::class, 'index'])->name('moodtracker.index');
    Route::post('/mahasiswa/moodtracker', [MoodTrackerController::class, 'store'])->name('moodtracker.store');

    // URL unik untuk Update dan Delete agar tidak bentrok
    Route::post('/mahasiswa/moodtracker/update/{id_Mood}', [MoodTrackerController::class, 'update'])->name('moodtracker.update');
    Route::post('/mahasiswa/moodtracker/delete/{id_Mood}', [MoodTrackerController::class, 'destroy'])->name('moodtracker.destroy');
    //artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    //Pengaturan Akun
    Route::get('/mahasiswa/profile', [ProfileController::class, 'edit'])
        ->name('mahasiswa.profile.edit');

    Route::put('/mahasiswa/profile', [ProfileController::class, 'update'])
        ->name('mahasiswa.profile.update');

    Route::put('/mahasiswa/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('mahasiswa.profile.password');
});

// ADMIN
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::post('/logout', function (Illuminate\Http\Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
    //Pertanyaan DASS21
    Route::resource('/pertanyaan', PertanyaanDASS21Controller::class);
    //Artikel Admin
    Route::resource('/artikel', ArtikelAdminController::class)->except(['show']);
    // Edit user
    Route::get('/manage-users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/manage-users/{type}/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/manage-users/{type}/{id}/update', [AdminController::class, 'update'])
    ->name('users.update');
    Route::delete('/users/{type}/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{type}/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users/{type}/store', [AdminController::class, 'store'])->name('users.store');
    //Atur Profile Admin
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    
    // Reset password
    Route::post('/manage-users/{type}/{id}/reset-password', [AdminController::class, 'resetPassword'])
        ->name('users.reset-password');

    // Nonaktifkan / Hapus user (soft delete)
    Route::post('/manage-users/{type}/{id}/delete', [AdminController::class, 'delete'])->name('users.delete');
});

// PSIKOLOG
Route::middleware(['auth:psikolog'])->prefix('psikolog')->name('psikolog.')->group(function () {

    Route::get('/dashboard', [PsikologController::class, 'dashboard'])
        ->name('dashboard');

    Route::post('/logout', function (Illuminate\Http\Request $request) {
        Auth::guard('psikolog')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/mahasiswa', [PsikologController::class, 'mahasiswaIndex'])
        ->name('mahasiswa.index');

    Route::get('/mahasiswa/{id}', [PsikologController::class, 'mahasiswaDetail'])
        ->name('mahasiswa.detail');
    

    // ✅ PROFILE PSIKOLOG
    Route::get('/profile', [PsikologProfileController::class, 'edit'])
    ->name('profile.edit');

    Route::put('/profile', [PsikologProfileController::class, 'update'])
        ->name('profile.update');
});

// Reset password mahasiswa
// 1. Tampilan Form Lupa Password (Tetap)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// 2. Proses Kirim Link ke Email (Tetap)
Route::post('/forgot-password', function (Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email|exists:mahasiswa,email'
    ], [
        'email.exists' => 'Email tidak terdaftar sebagai mahasiswa.'
    ]);

    $status = Password::broker('mahasiswa')->sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', 'Link reset password telah dikirim ke email.')
        : back()->withErrors(['email' => 'Gagal mengirim email reset.']);
})->middleware('guest')->name('password.email');

// 3. PERBAIKAN: Menampilkan Form Reset Password dengan menangkap Email dari URL
Route::get('/reset-password/{token}', function (Illuminate\Http\Request $request, string $token) {
    // Kita perlu menangkap 'email' dari request agar bisa di-passing ke view
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->email // Mengambil email dari ?email=... di URL
    ]);
})->middleware('guest')->name('password.reset');

// 4. Proses Update Password Baru (Tetap)
Route::post('/reset-password', function (Illuminate\Http\Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email|exists:mahasiswa,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::broker('mahasiswa')->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect('/login')->with('success', 'Password berhasil direset. Silakan login.')
        : back()->withErrors(['email' => 'Token reset tidak valid atau kadaluarsa.']);
})->middleware('guest')->name('password.update');

