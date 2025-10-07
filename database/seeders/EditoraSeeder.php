<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Editora;

class EditoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $editoras = [
            ['nome' => 'Editora Companhia das Letras'],
            ['nome' => 'Editora Record'],
            ['nome' => 'Editora Globo Livros'],
            ['nome' => 'Editora Intrínseca'],
            ['nome' => 'Editora Suma de Letras'],
        ];

        foreach ($editoras as $editora) {
            // Evita duplicações caso o seeder rode múltiplas vezes
            Editora::updateOrCreate(['nome' => $editora['nome']], []);
        }
    }
}
