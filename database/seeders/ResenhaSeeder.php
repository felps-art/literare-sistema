<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resenha;
use App\Models\Livro;
use App\Models\User;

class ResenhaSeeder extends Seeder
{
    public function run(): void
    {
        if (Resenha::query()->exists()) {
            $this->command?->info('ResenhaSeeder: tabela resenhas já possui registros, ignorando.');
            return;
        }

        $livros = Livro::all();
        $users = User::all();

        if ($livros->isEmpty() || $users->isEmpty()) {
            $this->command?->warn('ResenhaSeeder: sem livros ou usuários, nenhuma resenha criada.');
            return;
        }

        foreach ($livros as $livro) {
            $qtd = rand(0,3);
            if ($qtd === 0) continue; // nenhum para este livro

            // Seleciona usuários aleatórios sem repetição
            $usuariosSelecionados = $users->random(min($qtd, $users->count()));
            foreach (\Illuminate\Support\Arr::wrap($usuariosSelecionados) as $user) {
                Resenha::factory()->create([
                    'livro_id' => $livro->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        $this->command?->info('ResenhaSeeder: resenhas aleatórias criadas.');
    }
}
