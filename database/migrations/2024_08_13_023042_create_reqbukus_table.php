<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reqbukus', function (Blueprint $table) {
            $table->id();
            $table->string('id_anggota');
            $table->string('judulbuku');
            $table->string('id_kategori');
            $table->string('tanggal');
            $table->string('tahun');
            $table->string('keterangan');
            $table->string('author');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reqbukus');
    }
};
