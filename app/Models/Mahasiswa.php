<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        return $this->hasOne(
            HasilDASS21::class,
            'Mahasiswa_id_Mahasiswa',
            'id_Mahasiswa'
        )->latest('tanggal_test');
    }

    // Mood terakhir
    public function moodTerakhir()
    {
        return $this->hasOne(
            MoodTracker::class,
            'Mahasiswa_id_Mahasiswa',
            'id_Mahasiswa'
        )->latest('tanggal_input');
    }
}
