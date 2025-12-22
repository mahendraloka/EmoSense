<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanDASS21 extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_dass21';
    protected $primaryKey = 'id_Pertanyaan';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = ['urutan','teks_pertanyaan', 'kategori'];
}
