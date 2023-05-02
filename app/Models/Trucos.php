<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trucos extends Model
{
    use HasFactory;
    protected $table = 'trucos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
