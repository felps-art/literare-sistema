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
        ['nome' => 'Ana', 'codigo' => 'AUT005', 'biografia' => 'Autora de literatura jovem adulto'],
        ['nome' => 'Matt Haig', 'codigo' => 'AUT006', 'biografia' => 'Escritor britânico autor de "A Biblioteca da Meia-Noite"'],
        ['nome' => 'Hanya Yanagihara', 'codigo' => 'AUT007', 'biografia' => 'Escritora americana conhecida por "Uma Vida Pequena"'],
        ['nome' => 'Sophie Kinsella', 'codigo' => 'AUT008', 'biografia' => 'Escritora britânica de comédias românticas'],
        ['nome' => 'Carla Madeira', 'codigo' => 'AUT009', 'biografia' => 'Escritora brasileira autora de "Tudo é Rio"'],
        ['nome' => 'Holly Black', 'codigo' => 'AUT010', 'biografia' => 'Escritora americana de fantasia para jovens adultos'],
        ['nome' => 'Joanna Gaines', 'codigo' => 'AUT011', 'biografia' => 'Escritora e designer de interiores'],
        ['nome' => 'Neil Gaiman', 'codigo' => 'AUT012', 'biografia' => 'Escritor britânico de ficção especulativa e fantasia'],
        ['nome' => 'R.F. Kuang', 'codigo' => 'AUT013', 'biografia' => 'Escritora chinesa-americana de fantasia'],
        ['nome' => 'Mona Kasten', 'codigo' => 'AUT014', 'biografia' => 'Escritora alemã de romances new adult'],
        ['nome' => 'Sarah J. Maas', 'codigo' => 'AUT015', 'biografia' => 'Escritora americana de fantasia para jovens adultos'],
        ['nome' => 'Ana Rüsche', 'codigo' => 'AUT016', 'biografia' => 'Escritora brasileira contemporânea'],
        ['nome' => 'George R. R. Martin', 'codigo' => 'AUT017', 'biografia' => 'Escritor americano de fantasia épica'],
        ['nome' => 'Lygia F. Bojunga', 'codigo' => 'AUT018', 'biografia' => 'Escritora brasileira de literatura infantojuvenil'],
        ['nome' => 'Colleen Hoover', 'codigo' => 'AUT019', 'biografia' => 'Escritora americana de romance e ficção contemporânea'],
        ['nome' => 'Emily Brontë', 'codigo' => 'AUT020', 'biografia' => 'Escritora britânica do século XIX, autora de "O Morro dos Ventos Uivantes"'],
        ['nome' => 'Sally Thorne', 'codigo' => 'AUT021', 'biografia' => 'Escritora australiana de romances contemporâneos'],
        ['nome' => 'Christina Lauren', 'codigo' => 'AUT022', 'biografia' => 'Dupla de escritoras americanas de romance'],
        ['nome' => 'T. L. Swan', 'codigo' => 'AUT023', 'biografia' => 'Escritora australiana de romances eróticos'],
        ['nome' => 'Lee J. Myles', 'codigo' => 'AUT024', 'biografia' => 'Escritora de romance contemporâneo'],
        ['nome' => 'Raven Kennedy', 'codigo' => 'AUT025', 'biografia' => 'Escritora de fantasia e romance']
    ];

        foreach ($autores as $autor) {
            Autor::updateOrCreate([
                'codigo' => $autor['codigo'],
            ], $autor);
        }
    }
}
