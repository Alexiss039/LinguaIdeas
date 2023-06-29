<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicios;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $terminos = $request->input('terminos');
        $request->session()->put('terminos', $terminos);

        $resultados = DB::table('lecciones')
            ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
            ->addSelect(DB::raw("'lecciones' AS tabla")) // Agregar la columna "tabla" con el valor 'lecciones'
            ->where(function ($query) use ($terminos) {
                $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                      ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
            })
            ->orWhereRaw('nombre IN (SELECT nombre FROM entrevistas WHERE nombre LIKE ?)', ['%'.$terminos.'%'])
            ->unionAll(
                DB::table('ejercicios')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'ejercicios' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('juegos')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'juegos' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('recursos')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'recursos' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('pronunciacion')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'pronunciacion' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('gramatica')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'gramatica' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('pruebas')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'pruebas' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('trucos')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'trucos' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('videos')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'videos' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('memes')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'memes' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('historias')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'historias' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('temas')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'temas' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('entrevistas')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'entrevistas' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('examenes')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'examenes' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('innovacion')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'innovacion' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('eventos')
                    ->select('id','tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->addSelect(DB::raw("'eventos' AS tabla"))
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->paginate(8);
        
        return view('buscar', ['resultados' => $resultados, 'terminos' => $terminos]);
    }
}
