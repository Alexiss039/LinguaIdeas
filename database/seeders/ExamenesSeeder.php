<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('examenes')->insert([
            [
                'nombre' => 'prueba 1',
                'descripcion' => 'descripcion numero uno',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 2',
                'descripcion' => 'descripcion numero dos',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 3',
                'descripcion' => 'descripcion numero tres',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 4',
                'descripcion' => 'descripcion numero cuatro',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 5',
                'descripcion' => 'descripcion numero cinco',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 6',
                'descripcion' => 'descripcion numero seis',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 7',
                'descripcion' => 'descripcion numero siete',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 8',
                'descripcion' => 'descripcion numero ocho',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 9',
                'descripcion' => 'descripcion numero nueve',
                'enlace' => 'N/A',
            ],
            [
                'nombre' => 'prueba 10',
                'descripcion' => 'descripcion numero diez',
                'enlace' => 'N/A',
            ],
        
        ]);
    }
}
