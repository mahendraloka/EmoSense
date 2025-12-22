<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Penting untuk hashing

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan check agar truncate lancar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin')->truncate(); // Nama tabel harus huruf kecil sesuai migrasi
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('admin')->insert([
            [
                'id_Admin'   => 1,
                'nama'       => 'Duta Admin',
                'email'      => 'admin@gmail.com',
                'password'   => Hash::make('admin123'), // WAJIB di-hash agar bisa masuk & login
                'created_at' => '2025-12-08 18:45:50',
                'updated_at' => '2025-12-20 22:46:28',
            ]
        ]);
    }
}