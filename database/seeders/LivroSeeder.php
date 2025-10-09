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
            ],
            // Novos livros adicionados
            [
                'titulo' => 'A Biblioteca da Meia-Noite',
                'codigo_livro' => 'LIV011',
                'ano_publicacao' => 2020,
                'numero_paginas' => 336,
                'sinopse' => 'Entre a vida e a morte existe uma biblioteca. E as prateleiras dessa biblioteca são infinitas.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Matt Haig']
            ],
            [
                'titulo' => 'Uma vida pequena',
                'codigo_livro' => 'LIV012',
                'ano_publicacao' => 2016,
                'numero_paginas' => 720,
                'sinopse' => 'A história de quatro amigos em Nova York e suas lutas com trauma e amizade.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Hanya Yanagihara']
            ],
            [
                'titulo' => 'Se não fosse você',
                'codigo_livro' => 'LIV013',
                'ano_publicacao' => 2021,
                'numero_paginas' => 368,
                'sinopse' => 'Uma história sobre segundas chances e o poder transformador do amor.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Sophie Kinsella']
            ],
            [
                'titulo' => 'Tudo é rio',
                'codigo_livro' => 'LIV014',
                'ano_publicacao' => 2015,
                'numero_paginas' => 192,
                'sinopse' => 'Um romance sobre paixão, perda e redenção nas margens de um rio.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Carla Madeira']
            ],
            [
                'titulo' => 'O príncipe cruel',
                'codigo_livro' => 'LIV015',
                'ano_publicacao' => 2018,
                'numero_paginas' => 384,
                'sinopse' => 'Jude era uma mortal criada no Reino das Fadas, mas desejava pertencer a esse mundo perigoso.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Holly Black']
            ],
            [
                'titulo' => 'Amanhecer na colheita',
                'codigo_livro' => 'LIV016',
                'ano_publicacao' => 2022,
                'numero_paginas' => 256,
                'sinopse' => 'Reflexões sobre a vida simples e a beleza das coisas cotidianas.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Joanna Gaines']
            ],
            [
                'titulo' => 'Coraline',
                'codigo_livro' => 'LIV017',
                'ano_publicacao' => 2002,
                'numero_paginas' => 208,
                'sinopse' => 'Coraline descobre uma porta secreta que leva a uma versão alternativa de sua casa.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Neil Gaiman']
            ],
            [
                'titulo' => 'A guerra da papoula vol.1',
                'codigo_livro' => 'LIV018',
                'ano_publicacao' => 2018,
                'numero_paginas' => 544,
                'sinopse' => 'Uma jovem órfã se infiltra na academia militar do império que conquistou sua terra natal.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['R.F. Kuang']
            ],
            [
                'titulo' => 'Maxton Hall: Salve-me',
                'codigo_livro' => 'LIV019',
                'ano_publicacao' => 2019,
                'numero_paginas' => 480,
                'sinopse' => 'Ruby Bell cai nos braços de um dos alunos mais ricos e arrogantes da escola.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Mona Kasten']
            ],
            [
                'titulo' => 'Corte de gelo e estrelas',
                'codigo_livro' => 'LIV020',
                'ano_publicacao' => 2021,
                'numero_paginas' => 768,
                'sinopse' => 'Feyre retorna à Corte da Primavera em uma missão perigosa.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Sarah J. Maas']
            ],
            [
                'titulo' => 'Apostando no amor',
                'codigo_livro' => 'LIV021',
                'ano_publicacao' => 2020,
                'numero_paginas' => 320,
                'sinopse' => 'Dois opostos se atraem em uma aposta que pode mudar suas vidas.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Ana Rüsche']
            ],
            [
                'titulo' => 'A Ascensão do Dragão',
                'codigo_livro' => 'LIV022',
                'ano_publicacao' => 2022,
                'numero_paginas' => 736,
                'sinopse' => 'Novo volume da saga de George R. R. Martin sobre Westeros.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['George R. R. Martin']
            ],
            [
                'titulo' => 'Imperfeitos',
                'codigo_livro' => 'LIV023',
                'ano_publicacao' => 2018,
                'numero_paginas' => 224,
                'sinopse' => 'História sobre aceitação das próprias imperfeições.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Lygia F. Bojunga']
            ],
            [
                'titulo' => 'Trono de vidro: Herdeira do Fogo',
                'codigo_livro' => 'LIV024',
                'ano_publicacao' => 2015,
                'numero_paginas' => 672,
                'sinopse' => 'Terceiro livro da série Trono de Vidro.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Sarah J. Maas']
            ],
            [
                'titulo' => 'O lado feio do amor',
                'codigo_livro' => 'LIV025',
                'ano_publicacao' => 2014,
                'numero_paginas' => 336,
                'sinopse' => 'Uma história sobre amor e perda entre dois jovens com passados complicados.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Colleen Hoover']
            ],
            [
                'titulo' => 'Trono de vidro',
                'codigo_livro' => 'LIV026',
                'ano_publicacao' => 2012,
                'numero_paginas' => 392,
                'sinopse' => 'Primeiro livro da série sobre Celaena Sardothien, uma assassina lendária.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Sarah J. Maas']
            ],
            [
                'titulo' => 'De férias com você',
                'codigo_livro' => 'LIV027',
                'ano_publicacao' => 2020,
                'numero_paginas' => 288,
                'sinopse' => 'Dois desconhecidos fingem ser um casal durante as férias familiares.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Emily Brontë']
            ],
            [
                'titulo' => 'O morro dos ventos uivantes',
                'codigo_livro' => 'LIV028',
                'ano_publicacao' => 1847,
                'numero_paginas' => 416,
                'sinopse' => 'Clássico sobre a paixão destrutiva entre Catherine e Heathcliff.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Emily Brontë']
            ],
            [
                'titulo' => 'Táticas do amor',
                'codigo_livro' => 'LIV029',
                'ano_publicacao' => 2019,
                'numero_paginas' => 352,
                'sinopse' => 'Uma rivalidade no trabalho se transforma em atração incontrolável.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Sally Thorne']
            ],
            [
                'titulo' => 'Uma segunda chance',
                'codigo_livro' => 'LIV030',
                'ano_publicacao' => 2018,
                'numero_paginas' => 304,
                'sinopse' => 'Um casal separado pelo destino tem a oportunidade de recomeçar.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Christina Lauren']
            ],
            [
                'titulo' => 'Jogos do amor',
                'codigo_livro' => 'LIV031',
                'ano_publicacao' => 2021,
                'numero_paginas' => 320,
                'sinopse' => 'Dois rivais se envolvem em um jogo perigoso de sedução.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['T. L. Swan']
            ],
            [
                'titulo' => 'Novembro 9',
                'codigo_livro' => 'LIV032',
                'ano_publicacao' => 2015,
                'numero_paginas' => 320,
                'sinopse' => 'Dois jovens se encontram todo ano no mesmo dia para ver se o amor sobrevive.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Colleen Hoover']
            ],
            [
                'titulo' => 'Amor por engano',
                'codigo_livro' => 'LIV033',
                'ano_publicacao' => 2017,
                'numero_paginas' => 336,
                'sinopse' => 'Uma mulher se apaixona pelo homem que deveria odiar.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Lee J. Myles']
            ],
            [
                'titulo' => 'A professora',
                'codigo_livro' => 'LIV034',
                'ano_publicacao' => 2020,
                'numero_paginas' => 288,
                'sinopse' => 'Uma professora se envolve com um pai de aluno, desafiando todas as regras.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Raven Kennedy']
            ],
            [
                'titulo' => 'Aprendiz do Vilão',
                'codigo_livro' => 'LIV035',
                'ano_publicacao' => 2022,
                'numero_paginas' => 400,
                'sinopse' => 'Uma jovem se torna aprendiz do vilão mais temido do reino.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Raven Kennedy']
            ],
            [
                'titulo' => 'Não é como nos filmes',
                'codigo_livro' => 'LIV036',
                'ano_publicacao' => 2019,
                'numero_paginas' => 272,
                'sinopse' => 'Uma romântica incurável descobre que o amor real é diferente das comédias românticas.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Sophie Kinsella']
            ],
            [
                'titulo' => 'Depois daquele verão',
                'codigo_livro' => 'LIV037',
                'ano_publicacao' => 2021,
                'numero_paginas' => 352,
                'sinopse' => 'Um verão que muda tudo e as consequências que permanecem.',
                'editora_id' => $editoras->random()->id,
                'autores' => ['Colleen Hoover']
            ]
        ];
        foreach ($livros as $livroData) {
            $autoresNomes = $livroData['autores'];
            unset($livroData['autores']);

            // Garante idempotência através do codigo_livro
            $livro = Livro::updateOrCreate(
                ['codigo_livro' => $livroData['codigo_livro']],
                $livroData
            );

            // Monta lista de IDs de autores existentes
            $autorIds = [];
            foreach ($autoresNomes as $nomeAutor) {
                $autor = $autores->firstWhere('nome', $nomeAutor);
                if ($autor) {
                    $autorIds[] = $autor->id;
                }
            }
            if (!empty($autorIds)) {
                // syncWithoutDetaching evita duplicações no pivot
                $livro->autores()->syncWithoutDetaching($autorIds);
            }
        }
    }
}
