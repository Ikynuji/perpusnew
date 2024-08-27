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
        Schema::create('masterbukus', function (Blueprint $table) {
            $table->id();
            $table->string('cover');
            $table->string('judul');
            $table->string('author');
            $table->string('publisher');
            $table->string('isbn');
            $table->string('tahun');
            $table->string('stockbuku');
            $table->string('id_rak');
            $table->string('id_kategori');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masterbukus');
    }
};
