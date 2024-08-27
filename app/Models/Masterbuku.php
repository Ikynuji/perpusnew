<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterbuku extends Model
{
    use HasFactory;
    protected $fillable = [
        'cover', 'judul', 'author','publisher','isbn','tahun','stockbuku','id_rak','id_kategori'
    ];

    public function masterrak()
    {
        return $this->hasOne(Masterrak::class, 'id', 'id_rak');
    }
    public function masterkategori()
    {
        return $this->hasOne(Masterkategori::class, 'id', 'id_kategori');
    }
}


