<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recursos')->insert([
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 1',
                'descripcion' => 'descripcion numero uno',
               
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 2',
                'descripcion' => 'descripcion numero dos',
               
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 3',
                'descripcion' => 'descripcion numero tres',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 4',
                'descripcion' => 'descripcion numero cuatro',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 5',
                'descripcion' => 'descripcion numero cinco',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 6',
                'descripcion' => 'descripcion numero seis',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 7',
                'descripcion' => 'descripcion numero siete',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 8',
                'descripcion' => 'descripcion numero ocho',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 9',
                'descripcion' => 'descripcion numero nueve',
             
            ],
            [   'tipo' => 'recurso',
                'nombre' => 'prueba 10',
                'descripcion' => 'descripcion numero diez',
             
            ],
        
        ]);
    }
}
