<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('videos')->insert([
            [
                'nombre' => 'prueba 1',
                'descripcion' => 'descripcion numero uno',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 2',
                'descripcion' => 'descripcion numero dos',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 3',
                'descripcion' => 'descripcion numero tres',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 4',
                'descripcion' => 'descripcion numero cuatro',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 5',
                'descripcion' => 'descripcion numero cinco',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 6',
                'descripcion' => 'descripcion numero seis',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 7',
                'descripcion' => 'descripcion numero siete',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 8',
                'descripcion' => 'descripcion numero ocho',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 9',
                'descripcion' => 'descripcion numero nueve',
                'link' => 'null',
            ],
            [
                'nombre' => 'prueba 10',
                'descripcion' => 'descripcion numero diez',
                'link' => 'null',
            ],
        
        ]);
    }
}
