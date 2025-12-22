<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil_dass21', function (Blueprint $table) {

            $table->bigIncrements('id_Hasil');

            $table->unsignedBigInteger('Mahasiswa_id_Mahasiswa');
            $table->date('tanggal_test');
            
            $table->integer('skor_depresi');
            $table->integer('skor_anxiety');
            $table->integer('skor_stress');

            $table->string('tingkat_depresi');
            $table->string('tingkat_anxiety');
            $table->string('tingkat_stress');

            $table->timestamps();

            $table->foreign('Mahasiswa_id_Mahasiswa')
                  ->references('id_Mahasiswa')->on('mahasiswa')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_dass21');
    }
};
