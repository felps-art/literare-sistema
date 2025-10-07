<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Post;
use \App\Models\User;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listaUsuarios = User::all();
        $listaPosts = Post::all();

        if ($listaUsuarios->isEmpty() || $listaPosts->isEmpty()) {
            $this->command?->warn('LikesTableSeeder: sem usuários ou posts, ignorando.');
            return;
        }

        foreach ($listaUsuarios as $umUsuario) {
            $postsNaoCurtidos = $listaPosts->filter(function($p) use ($umUsuario){
                return !$p->isLikedBy($umUsuario); // evita criar like duplicado
            });

            if ($postsNaoCurtidos->isEmpty()) {
                continue;
            }

            // Limitamos picks para no máximo metade ou 10 (o que for menor) para variar sem exagero
            $maxRandom = min(10, max(1, (int) floor($postsNaoCurtidos->count() / 2)));
            $pick = rand(1, $maxRandom);
            $randomPosts = $postsNaoCurtidos->random($pick)->pluck('id')->all();
            $umUsuario->likedPosts()->syncWithoutDetaching($randomPosts);
        }

        // Atualiza cache likes_count em cada post
        foreach ($listaPosts as $post) {
            $post->likes_count = $post->likes()->count();
            $post->saveQuietly(); // evita disparar eventos desnecessários
        }
    }
}
