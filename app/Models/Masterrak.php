<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterrak extends Model
{
    use HasFactory;
    protected $fillable = [
        'rak','lantai'
    ];
}
