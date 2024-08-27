<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal','namanbuku','harga','keterangan','id_kategori','qty','tahun'
    ];
    public function masterkategori()
    {
        return $this->hasOne(Masterkategori::class, 'id', 'id_kategori');
    }
}
