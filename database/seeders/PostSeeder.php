<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        if (Post::query()->exists()) {
            $this->command?->info('PostSeeder: tabela posts já possui registros, ignorando.');
            return;
        }

        $users = User::all();
        if ($users->isEmpty()) {
            $this->command?->warn('PostSeeder: sem usuários, nenhum post criado.');
            return;
        }

        // Para cada usuário, gerar entre 1 e 5 posts
        foreach ($users as $user) {
            $count = rand(1,5);
            Post::factory()->count($count)->create([
                'user_id' => $user->id,
            ]);
        }

        $this->command?->info('PostSeeder: posts aleatórios criados.');
    }
}
