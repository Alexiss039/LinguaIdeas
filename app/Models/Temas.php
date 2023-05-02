<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temas extends Model
{
    use HasFactory;
    protected $table = 'temas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
