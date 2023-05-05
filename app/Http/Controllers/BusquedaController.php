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
            ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
            ->where(function ($query) use ($terminos) {
                $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                      ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
            })
            ->orWhereRaw('nombre IN (SELECT nombre FROM entrevistas WHERE nombre LIKE ?)', ['%'.$terminos.'%'])
            ->unionAll(
                DB::table('ejercicios')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('juegos')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('recursos')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('pronunciacion')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('gramatica')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('pruebas')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('trucos')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('videos')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('memes')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('historias')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('temas')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('entrevistas')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('examenes')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('innovacion')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->unionAll(
                DB::table('eventos')
                    ->select('tipo','nombre', 'descripcion','imagen','recurso','link','archivo','enlace')
                    ->where(function ($query) use ($terminos) {
                        $query->where('nombre', 'LIKE', '%'.$terminos.'%')
                              ->orWhere('descripcion', 'LIKE', '%'.$terminos.'%');
                    })
            )
            ->paginate(8);
        
        return view('buscar', ['resultados' => $resultados, 'terminos' => $terminos]);
    }
}
