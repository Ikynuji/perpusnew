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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('id_anggota');
            $table->string('id_buku');
            $table->string('keterangan')->nullable();
            $table->date('tanggalpinjam');
            $table->string('jumlah');
            $table->date('tenggat');
            $table->date('tglpengembalian')->nullable();
            $table->string('denda')->nullable();
            $table->string('status')->default('peminjaman');
            $table->string('bayar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
