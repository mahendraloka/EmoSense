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
        Schema::create('mood_tracker', function (Blueprint $table) {
            $table->string('id_Mood')->primary();
            $table->unsignedBigInteger('Mahasiswa_id_Mahasiswa');
            $table->date('tanggal_input');
            $table->integer('tingkat_mood');
            $table->text('catatan_harian')->nullable();
            $table->timestamps();
        
            $table->foreign('Mahasiswa_id_Mahasiswa')->references('id_Mahasiswa')->on('mahasiswa')
                  ->onDelete('cascade')->onUpdate('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mood_tracker');
    }
};
