<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecciones;
use App\Models\Ejercicios;
use App\Models\Entrevistas;
use App\Models\Gramatica;
use App\Models\Juegos;
use App\Models\Pronunciacion;
use App\Models\Pruebas;
use App\Models\Recursos;
use App\Models\Trucos;
use App\Models\Videos;
use App\Models\Memes;
use App\Models\Historias;
use App\Models\Temas;
use App\Models\Examenes;
use App\Models\Innovacion;
use App\Models\Eventos;

class IndexController extends Controller
{
    public function index()
    {
        $lecciones = Lecciones::count();
        $ejercicios = Ejercicios::count();
        $juegos = Juegos::count();
        $recursos = Recursos::count();
        $pronunciacion = Pronunciacion::count();
        $gramatica = Gramatica::count();
        $pruebas = Pruebas::count();
        $trucos = Trucos::count();

        $videos = Videos::count();
        $memes = Memes::count();
        $historias = Historias::count();

        $temas = Temas::count();
        $entrevistas = Entrevistas::count();

        $examenes = Examenes::count();
        $innovacion = Innovacion::count();
        $eventos = Eventos::count();

        $acti = $lecciones + $ejercicios + $juegos + $recursos + $pronunciacion + $gramatica + $pruebas + $trucos;

        $entretenimiento = $videos + $memes + $historias;

        $podcast = $temas + $entrevistas;

        $noticias = $examenes + $innovacion + $eventos;

        $data = [
            'acti' => $acti,
            'entretenimiento' => $entretenimiento,
            'podcast' => $podcast,
            'noticias' => $noticias,
        ];
        return view('index', $data);
    }
}
