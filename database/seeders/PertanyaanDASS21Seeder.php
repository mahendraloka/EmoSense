<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PertanyaanDASS21Seeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check sementara untuk kelancaran truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pertanyaan_dass21')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        $data = [
            ['urutan'=>1, 'teks_pertanyaan'=>'Saya merasa sulit untuk beristirahat.', 'kategori'=>'Stress'],
            ['urutan'=>2, 'teks_pertanyaan'=>'Saya merasa rongga mulut saya kering.', 'kategori'=>'Anxiety'],
            ['urutan'=>3, 'teks_pertanyaan'=>'Saya sama sekali tidak dapat merasakan perasaan positif (contoh: merasa gembira, bangga, dsb).', 'kategori'=>'Depression'],
            ['urutan'=>4, 'teks_pertanyaan'=>'Saya merasa kesulitan bernapas (misalnya sering terengah-engah tanpa aktivitas fisik).', 'kategori'=>'Anxiety'],
            ['urutan'=>5, 'teks_pertanyaan'=>'Saya merasa sulit berinisiatif melakukan sesuatu.', 'kategori'=>'Depression'],
            ['urutan'=>6, 'teks_pertanyaan'=>'Saya cenderung menunjukkan reaksi berlebihan terhadap suatu situasi.', 'kategori'=>'Stress'],
            ['urutan'=>7, 'teks_pertanyaan'=>'Saya merasa gemetar (misalnya pada tangan).', 'kategori'=>'Anxiety'],
            ['urutan'=>8, 'teks_pertanyaan'=>'Saya merasa energi saya terkuras karena terlalu cemas.', 'kategori'=>'Stress'],
            ['urutan'=>9, 'teks_pertanyaan'=>'Saya merasa khawatir dengan situasi di mana saya mungkin menjadi panik.', 'kategori'=>'Anxiety'],
            ['urutan'=>10, 'teks_pertanyaan'=>'Saya merasa tidak ada lagi yang bisa saya harapkan.', 'kategori'=>'Depression'],
            ['urutan'=>11, 'teks_pertanyaan'=>'Saya merasa gelisah.', 'kategori'=>'Stress'],
            ['urutan'=>12, 'teks_pertanyaan'=>'Saya merasa sulit untuk merasa tenang.', 'kategori'=>'Stress'],
            ['urutan'=>13, 'teks_pertanyaan'=>'Saya merasa sedih dan tertekan.', 'kategori'=>'Depression'],
            ['urutan'=>14, 'teks_pertanyaan'=>'Saya sulit untuk bersabar menghadapi gangguan.', 'kategori'=>'Stress'],
            ['urutan'=>15, 'teks_pertanyaan'=>'Saya merasa hampir panik.', 'kategori'=>'Anxiety'],
            ['urutan'=>16, 'teks_pertanyaan'=>'Saya tidak bisa merasa antusias terhadap hal apapun.', 'kategori'=>'Depression'],
            ['urutan'=>17, 'teks_pertanyaan'=>'Saya merasa hidup ini tidak berarti.', 'kategori'=>'Depression'],
            ['urutan'=>18, 'teks_pertanyaan'=>'Perasaan saya mudah tergugah atau tersentuh.', 'kategori'=>'Stress'],
            ['urutan'=>19, 'teks_pertanyaan'=>'Saya menyadari kondisi jantung saya meskipun tidak beraktivitas.', 'kategori'=>'Anxiety'],
            ['urutan'=>20, 'teks_pertanyaan'=>'Saya merasa ketakutan tanpa alasan yang jelas.', 'kategori'=>'Anxiety'],
            ['urutan'=>21, 'teks_pertanyaan'=>'Saya merasa diri saya tidak berharga.', 'kategori'=>'Depression'],
        ];

        // Tambahkan timestamp ke setiap item
        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('pertanyaan_dass21')->insert($data);
    }
}