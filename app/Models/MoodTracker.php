<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodTracker extends Model
{
    protected $table = 'mood_tracker';

    protected $primaryKey = 'id_Mood';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'id_Mood',
        'Mahasiswa_id_Mahasiswa',
        'tanggal_input',
        'tingkat_mood',
        'catatan_harian',
    ];

    protected $casts = [
        'tanggal_input' => 'date',
    ];
}
