<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\MoodTracker;
use App\Models\HasilDASS21;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_Mahasiswa';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'password',
        'fakultas',
        'prodi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new class($token) extends ResetPassword {
            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('Atur Ulang Kata Sandi Akun EmoSense Anda')
                    ->greeting('Halo, ' . $notifiable->nama . '!') // Menggunakan kolom 'nama' dari tabel mahasiswa Anda
                    ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun EmoSense Anda.')
                    ->action('Reset Kata Sandi', url(config('app.url').route('password.reset', [
                        'token' => $this->token,
                        'email' => $notifiable->getEmailForPasswordReset(),
                    ], false)))
                    ->line('Tautan ini sangat penting untuk keamanan akun Anda dan akan kedaluwarsa dalam 60 menit.')
                    ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini.')
                    ->salutation('Salam hangat, Tim EmoSense');
            }
        });
    }

    /* =============================
     * RELASI
     * ============================= */

    // Semua riwayat hasil DASS21
    public function hasilDASS21()
    {
        return $this->hasMany(
            HasilDASS21::class,
            'Mahasiswa_id_Mahasiswa',
            'id_Mahasiswa'
        );
    }

    // Semua riwayat mood tracker
    public function moodTracker()
    {
        return $this->hasMany(
            MoodTracker::class,
            'Mahasiswa_id_Mahasiswa',
            'id_Mahasiswa'
        );
    }

    // Hasil DASS21 terakhir
    public function dassTerakhir()
    {
        return $this->hasOne(HasilDASS21::class, 'Mahasiswa_id_Mahasiswa', 'id_Mahasiswa')
                    ->latestOfMany('id_Hasil'); // Jauh lebih aman untuk hosting
    }

    // Mood terakhir
    public function moodTerakhir()
    {
        return $this->hasOne(MoodTracker::class, 'Mahasiswa_id_Mahasiswa', 'id_Mahasiswa')
                    ->latestOfMany('id_Mood'); // Atau 'created_at'
    }
}
