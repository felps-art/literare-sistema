<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusLeitura;

class StatusLeituraSeeder extends Seeder
{
    public function run()
    {
        StatusLeitura::create(['nome' => 'Quero Ler', 'descricao' => 'Livros que deseja ler']);
        StatusLeitura::create(['nome' => 'Lendo', 'descricao' => 'Livros em leitura']);
        StatusLeitura::create(['nome' => 'Lido', 'descricao' => 'Livros finalizados']);
    }
}