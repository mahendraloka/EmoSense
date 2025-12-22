<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class Psikolog extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Psikolog';
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

    // Relasi dengan artikel
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'Psikolog_id_Psikolog');
    }
}
