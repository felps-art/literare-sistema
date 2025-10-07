<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Helper para criar dois usuários básicos
function createTwoUsers(): array {
    $u1 = User::factory()->create();
    $u2 = User::factory()->create();
    return [$u1, $u2];
}

it('permite seguir um usuário', function() {
    [$u1, $u2] = createTwoUsers();

    $this->actingAs($u1)
        ->post(route('users.follow', $u2))
        ->assertRedirect();

    expect($u1->isFollowing($u2))->toBeTrue();
});

it('é idempotente ao seguir novamente', function() {
    [$u1, $u2] = createTwoUsers();
    $this->actingAs($u1)->post(route('users.follow', $u2));
    $this->actingAs($u1)->post(route('users.follow', $u2));

    // Deve existir apenas um registro
    $count = DB::table('user_relationships')
        ->where('follower_id', $u1->id)
        ->where('followed_id', $u2->id)
        ->count();

    expect($count)->toBe(1);
});

it('permite deixar de seguir um usuário', function() {
    [$u1, $u2] = createTwoUsers();
    $this->actingAs($u1)->post(route('users.follow', $u2));

    $this->actingAs($u1)
        ->delete(route('users.unfollow', $u2))
        ->assertRedirect();

    expect($u1->isFollowing($u2))->toBeFalse();
});

it('impede seguir a si mesmo', function() {
    $u1 = User::factory()->create();
    $this->actingAs($u1)
        ->post(route('users.follow', $u1))
        ->assertRedirect();

    $count = DB::table('user_relationships')
        ->where('follower_id', $u1->id)
        ->count();
    expect($count)->toBe(0);
});

it('retorna 302 se não autenticado ao seguir', function() {
    [$u1, $u2] = createTwoUsers();

    $this->post(route('users.follow', $u2))
        ->assertStatus(302); // redireciona para login
});
