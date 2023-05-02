<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gramatica extends Model
{
    use HasFactory;
    protected $table = 'gramatica';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
