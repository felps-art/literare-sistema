<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autores = Autor::all();
        $editoras = Editora::all();

        $livros = [
            // Livros do Felipe
            [
                'titulo' => 'Viagem às Estrelas',
                'codigo_livro' => 'LIV001',
                'ano_publicacao' => 2023,
                'numero_paginas' => 320,
                'sinopse' => 'Uma jornada épica através do cosmos em busca de novas civilizações.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Felipe']
            ],
            [
                'titulo' => 'O Último Robô',
                'codigo_livro' => 'LIV002',
                'ano_publicacao' => 2024,
                'numero_paginas' => 280,
                'sinopse' => 'Em um futuro distópico, o último robô luta pela sobrevivência.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Felipe']
            ],
            // Livros do Ismael
            [
                'titulo' => 'Caminhos Perdidos',
                'codigo_livro' => 'LIV003',
                'ano_publicacao' => 2023,
                'numero_paginas' => 350,
                'sinopse' => 'Um romance sobre relacionamentos e descobertas pessoais.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Ismael']
            ],
            [
                'titulo' => 'Noites de Verão',
                'codigo_livro' => 'LIV004',
                'ano_publicacao' => 2024,
                'numero_paginas' => 295,
                'sinopse' => 'Uma história de amor ambientada em uma pequena cidade costeira.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Ismael']
            ],
            // Livros do Thierry
            [
                'titulo' => 'O Reino dos Dragões',
                'codigo_livro' => 'LIV005',
                'ano_publicacao' => 2023,
                'numero_paginas' => 420,
                'sinopse' => 'Uma aventura fantástica em um mundo povoado por criaturas mágicas.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Thierry']
            ],
            [
                'titulo' => 'A Magia Perdida',
                'codigo_livro' => 'LIV006',
                'ano_publicacao' => 2024,
                'numero_paginas' => 380,
                'sinopse' => 'A busca pela magia ancestral em um mundo moderno.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Thierry']
            ],
            // Livros do Gustavo
            [
                'titulo' => 'Líderes que Mudaram o Mundo',
                'codigo_livro' => 'LIV007',
                'ano_publicacao' => 2023,
                'numero_paginas' => 450,
                'sinopse' => 'Biografias de grandes líderes da história mundial.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Gustavo']
            ],
            [
                'titulo' => 'A Arte de Empreender',
                'codigo_livro' => 'LIV008',
                'ano_publicacao' => 2024,
                'numero_paginas' => 320,
                'sinopse' => 'Guia prático para o empreendedorismo moderno.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Gustavo']
            ],
            // Livros da Ana
            [
                'titulo' => 'Corações Rebeldes',
                'codigo_livro' => 'LIV009',
                'ano_publicacao' => 2023,
                'numero_paginas' => 290,
                'sinopse' => 'Uma história de amor e amadurecimento na adolescência.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Ana']
            ],
            [
                'titulo' => 'Entre Sonhos e Realidade',
                'codigo_livro' => 'LIV010',
                'ano_publicacao' => 2024,
                'numero_paginas' => 310,
                'sinopse' => 'Jovens enfrentando desafios e descobrindo seus caminhos.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Ana']
            ]
        ];

        foreach ($livros as $livroData) {
            $autoresNomes = $livroData['autores'];
            unset($livroData['autores']);
            
            $livro = Livro::create($livroData);
            
            // Associa os autores
            foreach ($autoresNomes as $nomeAutor) {
                $autor = $autores->where('nome', $nomeAutor)->first();
                if ($autor) {
                    $livro->autores()->attach($autor->id);
                }
            }
        }
    }
}
