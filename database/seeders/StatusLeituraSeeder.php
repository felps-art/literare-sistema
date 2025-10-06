<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusLeitura;

class StatusLeituraSeeder extends Seeder
{
    public function run()
    {
        $dados = [
            ['nome' => 'Quero Ler', 'descricao' => 'Livros que deseja ler'],
            ['nome' => 'Lendo', 'descricao' => 'Livros em leitura'],
            ['nome' => 'Lido', 'descricao' => 'Livros finalizados'],
        ];

        foreach ($dados as $item) {
            StatusLeitura::updateOrCreate(
                ['nome' => $item['nome']],
                ['descricao' => $item['descricao']]
            );
        }
    }
}