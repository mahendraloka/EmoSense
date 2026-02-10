<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;



class Psikolog extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'psikolog';
    protected $primaryKey = 'id_Psikolog';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_Psikolog',
        'nama',
        'email',
        'password',
        'nomor_str',
        'spesialisasi',
        'nomor_hp',
        'foto_profil',
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
                    ->subject('Pemulihan Akses Akun Profesional EmoSense')
                    ->greeting('Yth. Bapak/Ibu ' . $notifiable->nama . ',')
                    ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun profesional Anda di platform EmoSense.')
                    ->action('Atur Ulang Kata Sandi', url(config('app.url').route('password.reset', [
                        'token' => $this->token,
                        'email' => $notifiable->getEmailForPasswordReset(),
                    ], false)))
                    ->line('Tautan ini akan kedaluwarsa dalam 60 menit demi menjaga keamanan data profesional Anda.')
                    ->line('Jika Anda tidak merasa melakukan permintaan ini, mohon abaikan email ini atau hubungi administrator sistem.')
                    ->salutation('Salam hormat, Tim EmoSense');
            }
        });
    }

    // Relasi dengan artikel
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'Psikolog_id_Psikolog');
    }
}
