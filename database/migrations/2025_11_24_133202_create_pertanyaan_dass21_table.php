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
        Schema::create('pertanyaan_dass21', function (Blueprint $table) {
            $table->id('id_Pertanyaan');
            $table->text('teks_pertanyaan');
            $table->string('kategori'); // depresi / anxiety / stress
            $table->unsignedTinyInteger('urutan')->unique()->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_dass21');
    }
};
