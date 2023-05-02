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
        Schema::create('pronunciacion', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['recurso', 'multimedia','enlace','formulario']);
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('imagen')->nullable();
            $table->string('recurso')->nullable();
            $table->text('link')->nullable();
            $table->string('archivo')->nullable();
            $table->text('enlace')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pronunciacion');
    }
};
