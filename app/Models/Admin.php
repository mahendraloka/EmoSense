<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Sesuaikan dengan nama tabel di migrasi (huruf kecil semua)
    protected $table = 'admin'; 
    protected $primaryKey = 'id_Admin';
    public $timestamps = true;

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'email',
        'password',
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
                    ->subject('[Admin] Atur Ulang Kata Sandi Panel Control')
                    ->greeting('Halo, Administrator ' . $notifiable->nama)
                    ->line('Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun Admin EmoSense Anda.')
                    ->action('Reset Kata Sandi Admin', url(config('app.url').route('password.reset', [
                        'token' => $this->token,
                        'email' => $notifiable->getEmailForPasswordReset(),
                    ], false)))
                    ->line('Demi keamanan, tautan ini hanya berlaku selama 60 menit.')
                    ->line('Jika Anda tidak merasa melakukan permintaan ini, segera hubungi tim keamanan sistem.')
                    ->salutation('Salam, Sistem EmoSense');
            }
        });
    }
}