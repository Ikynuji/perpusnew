<?php

namespace App\Models;

use App\Models\Masterbuku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rusak extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_buku','kerusakan','qty','tanggal'
    ];
    public function masterbuku()
    {
        return $this->hasOne(Masterbuku::class, 'id', 'id_buku');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_anggota');
    }
}
