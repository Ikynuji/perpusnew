<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterebook extends Model
{
    use HasFactory;
    protected $fillable = [
        'cover', 'judul', 'author','publisher','isbn','tahun','filebuku'
    ];
}
