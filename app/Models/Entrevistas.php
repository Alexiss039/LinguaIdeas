<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrevistas extends Model
{
    use HasFactory;
    protected $table = 'entrevistas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function setVideoEmbedAttribute($value)
    {
        // Replace width and height with desired values
        $value = str_replace('width="560" height="315"', 'width="100%" height="250"', $value);

        $this->attributes['link'] = $value;
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'entrevista_id');
    }
}
