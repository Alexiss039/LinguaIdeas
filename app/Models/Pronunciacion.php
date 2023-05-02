<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pronunciacion extends Model
{
    use HasFactory;
    protected $table = 'pronunciacion';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
