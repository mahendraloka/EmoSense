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
        Schema::create('artikel', function (Blueprint $table) {
            $table->string('id_Artikel')->primary();
            $table->unsignedBigInteger('Psikolog_id_Psikolog')->nullable();
            $table->unsignedBigInteger('Admin_id_Admin')->nullable();
            $table->string('judul');
            $table->text('konten');
            // Gabungkan kolom kategori dari migrasi tambahan
            $table->enum('kategori', ['Depresi', 'Anxiety', 'Stress'])->nullable();
            // Gabungkan kolom gambar dari migrasi tambahan
            $table->string('gambar')->nullable();
            $table->date('tanggal_upload');
            $table->timestamps();
        
            $table->foreign('Psikolog_id_Psikolog')->references('id_Psikolog')->on('psikolog')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('Admin_id_Admin')->references('id_Admin')->on('admin')
                  ->onDelete('set null')->onUpdate('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
