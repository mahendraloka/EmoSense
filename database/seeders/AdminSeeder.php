<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Matikan Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Gunakan delete() jika truncate dilarang oleh provider hosting
        DB::table('admin')->delete(); 
        
        // 3. Reset Auto Increment (Opsional, agar ID kembali ke 1)
        DB::statement('ALTER TABLE admin AUTO_INCREMENT = 1;');

        // 4. Insert data
        DB::table('admin')->insert([
            [
                // id_Admin dihilangkan agar auto-increment yang bekerja
                'nama'       => 'Duta Admin',
                'email'      => 'admin@gmail.com',
                // Gunakan Hash::make atau langsung string hash dari DB lokal
                'password'   => Hash::make('admin123'), 
                'created_at' => '2025-12-08 18:45:50',
                'updated_at' => now(), // Gunakan helper now() agar lebih fleksibel
            ]
        ]);

        // 5. Hidupkan kembali Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}