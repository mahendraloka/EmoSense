<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id_Artikel';
    public $incrementing = false; // karena manual ID
    protected $keyType = 'string';

    protected $fillable = [
        'id_Artikel',
        'Psikolog_id_Psikolog',
        'Admin_id_Admin',
        'judul',
        'konten',
        'tanggal_upload',
        'kategori',
        'gambar',
    ];

    // Relasi opsional
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'Admin_id_Admin', 'id_Admin');
    }

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'Psikolog_id_Psikolog', 'id_Psikolog');
    }
}
