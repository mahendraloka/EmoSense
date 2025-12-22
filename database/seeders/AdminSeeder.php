<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel sebelum mengisi untuk menghindari duplikasi email
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('admin')->insert([
            [
                'nama'       => 'Duta Admin', // Sesuai dengan gambar
                'email'      => 'admin@gmail.com', // Sesuai dengan gambar
                'password'   => 'admin123',
                'created_at' => '2025-12-08 18:45:50', // Sesuai timestamp di gambar
                'updated_at' => '2025-12-20 22:46:28', // Sesuai timestamp di gambar
            ]
        ]);
    }
}