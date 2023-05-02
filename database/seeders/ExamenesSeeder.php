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
               
            ],
            [
                'nombre' => 'prueba 2',
                'descripcion' => 'descripcion numero dos',
               
            ],
            [
                'nombre' => 'prueba 3',
                'descripcion' => 'descripcion numero tres',
             
            ],
            [
                'nombre' => 'prueba 4',
                'descripcion' => 'descripcion numero cuatro',
             
            ],
            [
                'nombre' => 'prueba 5',
                'descripcion' => 'descripcion numero cinco',
             
            ],
            [
                'nombre' => 'prueba 6',
                'descripcion' => 'descripcion numero seis',
             
            ],
            [
                'nombre' => 'prueba 7',
                'descripcion' => 'descripcion numero siete',
             
            ],
            [
                'nombre' => 'prueba 8',
                'descripcion' => 'descripcion numero ocho',
             
            ],
            [
                'nombre' => 'prueba 9',
                'descripcion' => 'descripcion numero nueve',
             
            ],
            [
                'nombre' => 'prueba 10',
                'descripcion' => 'descripcion numero diez',
             
            ],
        
        ]);
    }
}
