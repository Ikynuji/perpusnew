<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjamanebook extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_anggota','id_ebook','tanggalpinjam'
    ];

    public function masterebook()
    {
        return $this->hasOne(Masterebook::class, 'id', 'id_ebook');
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
