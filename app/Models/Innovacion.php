<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Innovacion extends Model
{
    use HasFactory;
    protected $table = 'innovacion';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
