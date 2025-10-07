<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Resenha;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\StatusLeitura;
use App\Models\UsuarioLivroStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function seedBasics() {
    foreach ([
        ['nome' => 'Quero Ler', 'descricao' => ''],
        ['nome' => 'Lendo', 'descricao' => ''],
        ['nome' => 'Lido', 'descricao' => ''],
    ] as $d) {
        StatusLeitura::create($d);
    }
}

it('retorna feed com posts, resenhas e progresso', function() {
    seedBasics();
    $user = User::factory()->create();
    $followed = User::factory()->create();
    $user->follows()->attach($followed->id);

    $editora = Editora::create(['nome' => 'Editora Teste']);
    $livro = Livro::create([
        'titulo' => 'Livro Teste',
        'codigo_livro' => 'TESTE1',
        'ano_publicacao' => 2024,
        'numero_paginas' => 100,
        'sinopse' => 'Sinopse curta',
        'editora_id' => $editora->id,
    ]);

    // Criar post do followed
    Post::factory()->create(['user_id' => $followed->id]);
    // Criar resenha do followed
    Resenha::factory()->create(['user_id' => $followed->id, 'livro_id' => $livro->id]);
    // Criar progresso
    UsuarioLivroStatus::create([
        'user_id' => $followed->id,
        'livro_id' => $livro->id,
        'status_leitura_id' => 1,
        'avaliacao' => null,
    ]);

    $this->actingAs($user)
        ->getJson(route('feed.index'))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id','type','user','subject_type','subject_id','meta','created_at']
            ]
        ]);
});
