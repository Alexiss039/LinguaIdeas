<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leccion_id')->nullable();
            $table->unsignedBigInteger('ejercicio_id')->nullable();
            $table->unsignedBigInteger('juego_id')->nullable();
            $table->unsignedBigInteger('recurso_id')->nullable();
            $table->unsignedBigInteger('pronunciacion_id')->nullable();
            $table->unsignedBigInteger('gramatica_id')->nullable();
            $table->unsignedBigInteger('prueba_id')->nullable();
            $table->unsignedBigInteger('truco_id')->nullable();
            $table->unsignedBigInteger('video_id')->nullable();
            $table->unsignedBigInteger('meme_id')->nullable();
            $table->unsignedBigInteger('historia_id')->nullable();
            $table->unsignedBigInteger('tema_id')->nullable();
            $table->unsignedBigInteger('entrevista_id')->nullable();
            $table->unsignedBigInteger('examen_id')->nullable();
            $table->unsignedBigInteger('innovacion_id')->nullable();
            $table->unsignedBigInteger('evento_id')->nullable();
            $table->timestamps();
            $table->foreign('leccion_id')->references('id')->on('lecciones');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios');
            $table->foreign('juego_id')->references('id')->on('juegos');
            $table->foreign('recurso_id')->references('id')->on('recursos');
            $table->foreign('pronunciacion_id')->references('id')->on('pronunciacion');
            $table->foreign('gramatica_id')->references('id')->on('gramatica');
            $table->foreign('prueba_id')->references('id')->on('pruebas');
            $table->foreign('truco_id')->references('id')->on('trucos');
            $table->foreign('video_id')->references('id')->on('videos');
            $table->foreign('meme_id')->references('id')->on('memes');
            $table->foreign('historia_id')->references('id')->on('historias');
            $table->foreign('tema_id')->references('id')->on('temas');
            $table->foreign('entrevista_id')->references('id')->on('entrevistas');
            $table->foreign('examen_id')->references('id')->on('examenes');
            $table->foreign('innovacion_id')->references('id')->on('innovacion');
            $table->foreign('evento_id')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
