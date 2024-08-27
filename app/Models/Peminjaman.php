<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';
    protected $fillable = [
        'keterangan','id_rak','id_buku','id_anggota','tanggalpinjam','jumlah','tenggat','status','tglpengembalian','denda','status','bayar'
    ];

    public function masterbuku()
    {
        return $this->hasOne(Masterbuku::class, 'id', 'id_buku');
    }

    public function masteranggota()
    {
        return $this->hasOne(Masteranggota::class, 'id', 'id_anggota');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_anggota');
    }
    public function masterrak()
    {
        return $this->hasOne(Masterrak::class, 'id', 'id_rak');
    }
}
