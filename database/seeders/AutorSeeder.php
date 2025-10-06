<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Autor;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autores = [
            ['nome' => 'Felipe', 'codigo' => 'AUT001', 'biografia' => 'Autor especializado em ficção científica'],
            ['nome' => 'Ismael', 'codigo' => 'AUT002', 'biografia' => 'Escritor de romances contemporâneos'],
            ['nome' => 'Thierry', 'codigo' => 'AUT003', 'biografia' => 'Autor de literatura fantástica'],
            ['nome' => 'Gustavo', 'codigo' => 'AUT004', 'biografia' => 'Especialista em não-ficção e biografias'],
            ['nome' => 'Ana', 'codigo' => 'AUT005', 'biografia' => 'Autora de literatura jovem adulto']
        ];

        foreach ($autores as $autor) {
            Autor::updateOrCreate([
                'codigo' => $autor['codigo'],
            ], $autor);
        }
    }
}
