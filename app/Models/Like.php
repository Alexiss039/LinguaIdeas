<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'leccion_id',
       'ejercicio_id',
       'juego_id',
        'recurso_id',
     'pronunciacion_id',
     'gramatica_id',
        'prueba_id',
        'truco_id',
        'video_id',
        'meme_id',
       'historia_id',
        'tema_id',
      'entrevista_id',
        'examen_id',
       'innovacion_id',
        'evento_id',
    ];
    
    public function leccion()
    {
        return $this->belongsTo('App\Models\Lecciones');
    }
    public function Ejercicio()
    {
        return $this->belongsTo('App\Models\Ejercicios');
    }
    public function Juego()
    {
        return $this->belongsTo('App\Models\Juegos');
    }
    public function Recurso()
    {
        return $this->belongsTo('App\Models\Recursos');
    }
    public function Pronunciacion()
    {
        return $this->belongsTo('App\Models\Pronunciacion');
    }
    public function Gramatica()
    {
        return $this->belongsTo('App\Models\Gramatica');
    }
    public function Prueba()
    {
        return $this->belongsTo('App\Models\Pruebas');
    }
    public function Truco()
    {
        return $this->belongsTo('App\Models\Trucos');
    }
    public function Video()
    {
        return $this->belongsTo('App\Models\Videos');
    }
    public function Meme()
    {
        return $this->belongsTo('App\Models\Memes');
    }
    public function Historia()
    {
        return $this->belongsTo('App\Models\Historias');
    }
    public function Tema()
    {
        return $this->belongsTo('App\Models\Temas');
    }
    public function Entrevista()
    {
        return $this->belongsTo('App\Models\Entrevistas');
    }
    public function Examen()
    {
        return $this->belongsTo('App\Models\Examenes');
    }
    public function Innovacion()
    {
        return $this->belongsTo('App\Models\Innovacion');
    }
    public function Evento()
    {
        return $this->belongsTo('App\Models\Eventos');
    }
}
