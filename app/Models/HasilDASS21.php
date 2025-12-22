<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilDASS21 extends Model
{
    protected $table = 'hasil_dass21';

    protected $primaryKey = 'id_Hasil';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'Mahasiswa_id_Mahasiswa',
        'tanggal_test',
        'skor_depresi',
        'skor_anxiety',
        'skor_stress',
        'tingkat_depresi',
        'tingkat_anxiety',
        'tingkat_stress',
    ];
}
