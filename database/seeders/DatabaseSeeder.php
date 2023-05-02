<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(EjerciciosSeeder::class);
        $this->call(EntrevistasSeeder::class);
        $this->call(EventosSeeder::class);
        $this->call(ExamenesSeeder::class);
        $this->call(GramaticaSeeder::class);
        $this->call(HistoriasSeeder::class);
        $this->call(InnovacionSeeder::class);
        $this->call(JuegosSeeder::class);
        $this->call(LeccionesSeeder::class);
        $this->call(MemesSeeder::class);
        $this->call(PronunciacionSeeder::class);
        $this->call(PruebasSeeder::class);
        $this->call(RecursosSeeder::class);
        $this->call(TemasSeeder::class);
        $this->call(TrucosSeeder::class);
        $this->call(VideosSeeder::class);
        $this->call(UserSeeder::class);

    }
}
