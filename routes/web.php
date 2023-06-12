<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Auth::routes();



//Nosotros
Route::get('nosotros/index', [App\Http\Controllers\NosotrosController::class, 'index'])->name('nosotros.index');


Route::prefix('')->middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::get('lecciones/lista', [App\Http\Controllers\LeccionesController::class, 'lista'])->name('lecciones.lista');
    Route::get('lecciones/create', [App\Http\Controllers\LeccionesController::class, 'create'])->name('lecciones.create');
    Route::get('lecciones/{id}/edit', [App\Http\Controllers\LeccionesController::class, 'edit'])->name('lecciones.edit');
    Route::put('lecciones/{id}/update', [App\Http\Controllers\LeccionesController::class, 'update'])->name('lecciones.update');
    Route::post('lecciones/index', [App\Http\Controllers\LeccionesController::class, 'store'])->name('lecciones.store');
    Route::delete('lecciones/{id}', [App\Http\Controllers\LeccionesController::class, 'destroy'])->name('lecciones.destroy');


    Route::get('ejercicios/lista', [App\Http\Controllers\EjerciciosController::class, 'lista'])->name('ejercicios.lista');
    Route::get('ejercicios/create', [App\Http\Controllers\EjerciciosController::class, 'create'])->name('ejercicios.create');
    Route::get('ejercicios/{id}/edit', [App\Http\Controllers\EjerciciosController::class, 'edit'])->name('ejercicios.edit');
    Route::put('ejercicios/{id}/update', [App\Http\Controllers\EjerciciosController::class, 'update'])->name('ejercicios.update');
    Route::post('ejercicios/index', [App\Http\Controllers\EjerciciosController::class, 'store'])->name('ejercicios.store');
    Route::delete('ejercicios/{id}', [App\Http\Controllers\EjerciciosController::class, 'destroy'])->name('ejercicios.destroy');


    Route::get('juegos/lista', [App\Http\Controllers\JuegosController::class, 'lista'])->name('juegos.lista');
    Route::get('juegos/create', [App\Http\Controllers\JuegosController::class, 'create'])->name('juegos.create');
    Route::get('juegos/{id}/edit', [App\Http\Controllers\JuegosController::class, 'edit'])->name('juegos.edit');
    Route::put('juegos/{id}/update', [App\Http\Controllers\JuegosController::class, 'update'])->name('juegos.update');
    Route::post('juegos/index', [App\Http\Controllers\JuegosController::class, 'store'])->name('juegos.store');
    Route::delete('juegos/{id}', [App\Http\Controllers\JuegosController::class, 'destroy'])->name('juegos.destroy');


    Route::get('recursos/lista', [App\Http\Controllers\RecursosController::class, 'lista'])->name('recursos.lista');
    Route::get('recursos/create', [App\Http\Controllers\RecursosController::class, 'create'])->name('recursos.create');
    Route::get('recursos/{id}/edit', [App\Http\Controllers\RecursosController::class, 'edit'])->name('recursos.edit');
    Route::put('recursos/{id}/update', [App\Http\Controllers\RecursosController::class, 'update'])->name('recursos.update');
    Route::post('recursos/index', [App\Http\Controllers\RecursosController::class, 'store'])->name('recursos.store');
    Route::delete('recursos/{id}', [App\Http\Controllers\RecursosController::class, 'destroy'])->name('recursos.destroy');


    Route::get('pronunciacion/lista', [App\Http\Controllers\PronunciacionController::class, 'lista'])->name('pronunciacion.lista');
    Route::get('pronunciacion/create', [App\Http\Controllers\PronunciacionController::class, 'create'])->name('pronunciacion.create');
    Route::get('pronunciacion/{id}/edit', [App\Http\Controllers\PronunciacionController::class, 'edit'])->name('pronunciacion.edit');
    Route::put('pronunciacion/{id}/update', [App\Http\Controllers\PronunciacionController::class, 'update'])->name('pronunciacion.update');
    Route::post('pronunciacion/index', [App\Http\Controllers\PronunciacionController::class, 'store'])->name('pronunciacion.store');
    Route::delete('pronunciacion/{id}', [App\Http\Controllers\PronunciacionController::class, 'destroy'])->name('pronunciacion.destroy');


    Route::get('gramatica/lista', [App\Http\Controllers\GramaticaController::class, 'lista'])->name('gramatica.lista');
    Route::get('gramatica/create', [App\Http\Controllers\GramaticaController::class, 'create'])->name('gramatica.create');
    Route::get('gramatica/{id}/edit', [App\Http\Controllers\GramaticaController::class, 'edit'])->name('gramatica.edit');
    Route::put('gramatica/{id}/update', [App\Http\Controllers\GramaticaController::class, 'update'])->name('gramatica.update');
    Route::post('gramatica/index', [App\Http\Controllers\GramaticaController::class, 'store'])->name('gramatica.store');
    Route::delete('gramatica/{id}', [App\Http\Controllers\GramaticaController::class, 'destroy'])->name('gramatica.destroy');

    Route::get('pruebas/lista', [App\Http\Controllers\PruebasController::class, 'lista'])->name('pruebas.lista');
    Route::get('pruebas/create', [App\Http\Controllers\PruebasController::class, 'create'])->name('pruebas.create');
    Route::get('pruebas/{id}/edit', [App\Http\Controllers\PruebasController::class, 'edit'])->name('pruebas.edit');
    Route::put('pruebas/{id}/update', [App\Http\Controllers\PruebasController::class, 'update'])->name('pruebas.update');
    Route::post('pruebas/index', [App\Http\Controllers\PruebasController::class, 'store'])->name('pruebas.store');
    Route::delete('pruebas/{id}', [App\Http\Controllers\PruebasController::class, 'destroy'])->name('pruebas.destroy');

    Route::get('trucos/lista', [App\Http\Controllers\TrucosController::class, 'lista'])->name('trucos.lista');
    Route::get('trucos/create', [App\Http\Controllers\TrucosController::class, 'create'])->name('trucos.create');
    Route::get('trucos/{id}/edit', [App\Http\Controllers\TrucosController::class, 'edit'])->name('trucos.edit');
    Route::put('trucos/{id}/update', [App\Http\Controllers\TrucosController::class, 'update'])->name('trucos.update');
    Route::post('trucos/index', [App\Http\Controllers\TrucosController::class, 'store'])->name('trucos.store');
    Route::delete('trucos/{id}', [App\Http\Controllers\TrucosController::class, 'destroy'])->name('trucos.destroy');

    Route::get('videos/lista', [App\Http\Controllers\VideosController::class, 'lista'])->name('videos.lista');
    Route::get('videos/create', [App\Http\Controllers\VideosController::class, 'create'])->name('videos.create');
    Route::get('videos/{id}/edit', [App\Http\Controllers\VideosController::class, 'edit'])->name('videos.edit');
    Route::put('videos/{id}/update', [App\Http\Controllers\VideosController::class, 'update'])->name('videos.update');
    Route::post('videos/index', [App\Http\Controllers\VideosController::class, 'store'])->name('videos.store');
    Route::delete('videos/{id}', [App\Http\Controllers\VideosController::class, 'destroy'])->name('videos.destroy');

    Route::get('memes/lista', [App\Http\Controllers\MemesController::class, 'lista'])->name('memes.lista');
    Route::get('memes/create', [App\Http\Controllers\MemesController::class, 'create'])->name('memes.create');
    Route::get('memes/{id}/edit', [App\Http\Controllers\MemesController::class, 'edit'])->name('memes.edit');
    Route::put('memes/{id}/update', [App\Http\Controllers\MemesController::class, 'update'])->name('memes.update');
    Route::post('memes/index', [App\Http\Controllers\MemesController::class, 'store'])->name('memes.store');
    Route::delete('memes/{id}', [App\Http\Controllers\MemesController::class, 'destroy'])->name('memes.destroy');


    Route::get('historias/lista', [App\Http\Controllers\HistoriasController::class, 'lista'])->name('historias.lista');
    Route::get('historias/create', [App\Http\Controllers\HistoriasController::class, 'create'])->name('historias.create');
    Route::get('historias/{id}/edit', [App\Http\Controllers\HistoriasController::class, 'edit'])->name('historias.edit');
    Route::put('historias/{id}/update', [App\Http\Controllers\HistoriasController::class, 'update'])->name('historias.update');
    Route::post('historias/index', [App\Http\Controllers\HistoriasController::class, 'store'])->name('historias.store');
    Route::delete('historias/{id}', [App\Http\Controllers\HistoriasController::class, 'destroy'])->name('historias.destroy');


    Route::get('temas/lista', [App\Http\Controllers\TemasController::class, 'lista'])->name('temas.lista');
    Route::get('temas/create', [App\Http\Controllers\TemasController::class, 'create'])->name('temas.create');
    Route::get('temas/{id}/edit', [App\Http\Controllers\TemasController::class, 'edit'])->name('temas.edit');
    Route::put('temas/{id}/update', [App\Http\Controllers\TemasController::class, 'update'])->name('temas.update');
    Route::post('temas/index', [App\Http\Controllers\TemasController::class, 'store'])->name('temas.store');
    Route::delete('temas/{id}', [App\Http\Controllers\TemasController::class, 'destroy'])->name('temas.destroy');

    Route::get('entrevistas/lista', [App\Http\Controllers\EntrevistasController::class, 'lista'])->name('entrevistas.lista');
    Route::get('entrevistas/create', [App\Http\Controllers\EntrevistasController::class, 'create'])->name('entrevistas.create');
    Route::get('entrevistas/{id}/edit', [App\Http\Controllers\EntrevistasController::class, 'edit'])->name('entrevistas.edit');
    Route::put('entrevistas/{id}/update', [App\Http\Controllers\EntrevistasController::class, 'update'])->name('entrevistas.update');
    Route::post('entrevistas/index', [App\Http\Controllers\EntrevistasController::class, 'store'])->name('entrevistas.store');
    Route::delete('entrevistas/{id}', [App\Http\Controllers\EntrevistasController::class, 'destroy'])->name('entrevistas.destroy');

    Route::get('examenes/lista', [App\Http\Controllers\ExamenesController::class, 'lista'])->name('examenes.lista');
    Route::get('examenes/create', [App\Http\Controllers\ExamenesController::class, 'create'])->name('examenes.create');
    Route::get('examenes/{id}/edit', [App\Http\Controllers\ExamenesController::class, 'edit'])->name('examenes.edit');
    Route::put('examenes/{id}/update', [App\Http\Controllers\ExamenesController::class, 'update'])->name('examenes.update');
    Route::post('examenes/index', [App\Http\Controllers\ExamenesController::class, 'store'])->name('examenes.store');
    Route::delete('examenes/{id}', [App\Http\Controllers\ExamenesController::class, 'destroy'])->name('examenes.destroy');


    Route::get('innovacion/lista', [App\Http\Controllers\InnovacionController::class, 'lista'])->name('innovacion.lista');
    Route::get('innovacion/create', [App\Http\Controllers\InnovacionController::class, 'create'])->name('innovacion.create');
    Route::get('innovacion/{id}/edit', [App\Http\Controllers\InnovacionController::class, 'edit'])->name('innovacion.edit');
    Route::put('innovacion/{id}/update', [App\Http\Controllers\InnovacionController::class, 'update'])->name('innovacion.update');
    Route::post('innovacion/index', [App\Http\Controllers\InnovacionController::class, 'store'])->name('innovacion.store');
    Route::delete('innovacion/{id}', [App\Http\Controllers\InnovacionController::class, 'destroy'])->name('innovacion.destroy');


    Route::get('eventos/lista', [App\Http\Controllers\EventosController::class, 'lista'])->name('eventos.lista');
    Route::get('eventos/create', [App\Http\Controllers\EventosController::class, 'create'])->name('eventos.create');
    Route::get('eventos/{id}/edit', [App\Http\Controllers\EventosController::class, 'edit'])->name('eventos.edit');
    Route::put('eventos/{id}/update', [App\Http\Controllers\EventosController::class, 'update'])->name('eventos.update');
    Route::post('eventos/index', [App\Http\Controllers\EventosController::class, 'store'])->name('eventos.store');
    Route::delete('eventos/{id}', [App\Http\Controllers\EventosController::class, 'destroy'])->name('eventos.destroy');

});
//Lecciones
Route::get('lecciones/index', [App\Http\Controllers\LeccionesController::class, 'index'])->name('lecciones.index');
Route::get('lecciones/{id}', [App\Http\Controllers\LeccionesController::class, 'show'])->name('lecciones.show');
Route::post('lecciones/like', [App\Http\Controllers\LeccionesController::class, 'like'])->name('lecciones.like');
Route::post('lecciones/dislike', [App\Http\Controllers\LeccionesController::class, 'dislike'])->name('lecciones.dislike');

//Ejercicios
Route::get('ejercicios/index', [App\Http\Controllers\EjerciciosController::class, 'index'])->name('ejercicios.index');
Route::get('ejercicios/{id}', [App\Http\Controllers\EjerciciosController::class, 'show'])->name('ejercicios.show');
Route::post('ejercicios/like', [App\Http\Controllers\EjerciciosController::class, 'like'])->name('ejercicios.like');
Route::post('ejercicios/dislike', [App\Http\Controllers\EjerciciosController::class, 'dislike'])->name('ejercicios.dislike');

//Juegos
Route::get('juegos/index', [App\Http\Controllers\JuegosController::class, 'index'])->name('juegos.index');
Route::get('juegos/{id}', [App\Http\Controllers\JuegosController::class, 'show'])->name('juegos.show');
Route::post('juegos/like', [App\Http\Controllers\JuegosController::class, 'like'])->name('juegos.like');
Route::post('juegos/dislike', [App\Http\Controllers\JuegosController::class, 'dislike'])->name('juegos.dislike');

//Recursos
Route::get('recursos/index', [App\Http\Controllers\RecursosController::class, 'index'])->name('recursos.index');
Route::get('recursos/{id}', [App\Http\Controllers\RecursosController::class, 'show'])->name('recursos.show');
Route::post('recursos/like', [App\Http\Controllers\RecursosController::class, 'like'])->name('recursos.like');
Route::post('recursos/dislike', [App\Http\Controllers\RecursosController::class, 'dislike'])->name('recursos.dislike');

//Pronunciacion
Route::get('pronunciacion/index', [App\Http\Controllers\PronunciacionController::class, 'index'])->name('pronunciacion.index');
Route::get('pronunciacion/{id}', [App\Http\Controllers\PronunciacionController::class, 'show'])->name('pronunciacion.show');
Route::post('pronunciacion/like', [App\Http\Controllers\PronunciacionController::class, 'like'])->name('pronunciacion.like');
Route::post('pronunciacion/dislike', [App\Http\Controllers\PronunciacionController::class, 'dislike'])->name('pronunciacion.dislike');

//Gramatica
Route::get('gramatica/index', [App\Http\Controllers\GramaticaController::class, 'index'])->name('gramatica.index');
Route::get('gramatica/{id}', [App\Http\Controllers\GramaticaController::class, 'show'])->name('gramatica.show');
Route::post('gramatica/like', [App\Http\Controllers\GramaticaController::class, 'like'])->name('gramatica.like');
Route::post('gramatica/dislike', [App\Http\Controllers\GramaticaController::class, 'dislike'])->name('gramatica.dislike');

//Pruebas
Route::get('pruebas/index', [App\Http\Controllers\PruebasController::class, 'index'])->name('pruebas.index');
Route::get('pruebas/{id}', [App\Http\Controllers\PruebasController::class, 'show'])->name('pruebas.show');
Route::post('pruebas/like', [App\Http\Controllers\PruebasController::class, 'like'])->name('pruebas.like');
Route::post('pruebas/dislike', [App\Http\Controllers\PruebasController::class, 'dislike'])->name('pruebas.dislike');

//Trucos
Route::get('trucos/index', [App\Http\Controllers\TrucosController::class, 'index'])->name('trucos.index');
Route::get('trucos/{id}', [App\Http\Controllers\TrucosController::class, 'show'])->name('trucos.show');
Route::post('trucos/like', [App\Http\Controllers\TrucosController::class, 'like'])->name('trucos.like');
Route::post('trucos/dislike', [App\Http\Controllers\TrucosController::class, 'dislike'])->name('trucos.dislike');

//videos
Route::get('videos/index', [App\Http\Controllers\VideosController::class, 'index'])->name('videos.index');
Route::post('videos/like', [App\Http\Controllers\VideosController::class, 'like'])->name('videos.like');
Route::post('videos/dislike', [App\Http\Controllers\VideosController::class, 'dislike'])->name('videos.dislike');

//memes
Route::get('memes/index', [App\Http\Controllers\MemesController::class, 'index'])->name('memes.index');
Route::get('memes/{id}', [App\Http\Controllers\MemesController::class, 'show'])->name('memes.show');
Route::post('memes/like', [App\Http\Controllers\MemesController::class, 'like'])->name('memes.like');
Route::post('memes/dislike', [App\Http\Controllers\MemesController::class, 'dislike'])->name('memes.dislike');

//historias
Route::get('historias/index', [App\Http\Controllers\HistoriasController::class, 'index'])->name('historias.index');
Route::get('historias/{id}', [App\Http\Controllers\HistoriasController::class, 'show'])->name('historias.show');
Route::post('historias/like', [App\Http\Controllers\HistoriasController::class, 'like'])->name('historias.like');
Route::post('historias/dislike', [App\Http\Controllers\HistoriasController::class, 'dislike'])->name('historias.dislike');

//Temas
Route::get('temas/index', [App\Http\Controllers\TemasController::class, 'index'])->name('temas.index');
Route::get('temas/{id}', [App\Http\Controllers\TemasController::class, 'show'])->name('temas.show');
Route::post('temas/like', [App\Http\Controllers\TemasController::class, 'like'])->name('temas.like');
Route::post('temas/dislike', [App\Http\Controllers\TemasController::class, 'dislike'])->name('temas.dislike');

//Entrevistas
Route::get('entrevistas/index', [App\Http\Controllers\EntrevistasController::class, 'index'])->name('entrevistas.index');
Route::get('entrevistas/{id}', [App\Http\Controllers\EntrevistasController::class, 'show'])->name('entrevistas.show');
Route::post('entrevistas/like', [App\Http\Controllers\EntrevistasController::class, 'like'])->name('entrevistas.like');
Route::post('entrevistas/dislike', [App\Http\Controllers\EntrevistasController::class, 'dislike'])->name('entrevistas.dislike');

//Examenes
Route::get('examenes/index', [App\Http\Controllers\ExamenesController::class, 'index'])->name('examenes.index');
Route::get('examenes/{id}', [App\Http\Controllers\ExamenesController::class, 'show'])->name('examenes.show');
Route::post('examenes/like', [App\Http\Controllers\ExamenesController::class, 'like'])->name('examenes.like');
Route::post('examenes/dislike', [App\Http\Controllers\ExamenesController::class, 'dislike'])->name('examenes.dislike');

//Innovacion
Route::get('innovacion/index', [App\Http\Controllers\InnovacionController::class, 'index'])->name('innovacion.index');
Route::get('innovacion/{id}', [App\Http\Controllers\InnovacionController::class, 'show'])->name('innovacion.show');
Route::post('innovacion/like', [App\Http\Controllers\InnovacionController::class, 'like'])->name('innovacion.like');
Route::post('innovacion/dislike', [App\Http\Controllers\InnovacionController::class, 'dislike'])->name('innovacion.dislike');

//Eventos
Route::get('eventos/index', [App\Http\Controllers\EventosController::class, 'index'])->name('eventos.index');
Route::get('eventos/{id}', [App\Http\Controllers\EventosController::class, 'show'])->name('eventos.show');
Route::post('eventos/like', [App\Http\Controllers\EventosController::class, 'like'])->name('eventos.like');
Route::post('eventos/dislike', [App\Http\Controllers\EventosController::class, 'dislike'])->name('eventos.dislike');

//Testimonios
Route::get('testimonios/index', [App\Http\Controllers\TestimoniosController::class, 'index'])->name('testimonios.index');

//Terminos
Route::get('terminos/index', [App\Http\Controllers\TerminosController::class, 'index'])->name('terminos.index');


Route::get('/buscar', [\App\Http\Controllers\BusquedaController::class, 'buscar'])->name('buscar');