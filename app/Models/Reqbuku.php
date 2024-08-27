<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reqbuku extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_anggota','id_kategori','judulbuku','tanggal','tahun','author','keterangan'
    ];

    public function masterkategori()
    {
        return $this->hasOne(Masterkategori::class, 'id', 'id_kategori');
    }
    public function masteranggota()
    {
        return $this->hasOne(Masteranggota::class, 'id', 'id_anggota');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_anggota');
    }
}
