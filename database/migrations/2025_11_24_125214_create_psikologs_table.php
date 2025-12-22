<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('psikolog', function (Blueprint $table) {
            $table->id('id_Psikolog');
            $table->string('nama');
            $table->string('foto_profil')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('nomor_hp');
            $table->string('nomor_str');
            $table->string('spesialisasi');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psikolog');
    }
};
