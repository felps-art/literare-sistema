<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Resenha>
 */
class ResenhaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'livro_id' => Livro::query()->inRandomOrder()->value('id'),
            'conteudo' => $this->faker->paragraphs(rand(2,4), true),
            'avaliacao' => rand(0,10) > 2 ? rand(1,5) : null, // às vezes sem avaliação
            'spoiler' => rand(0,10) > 7, // ~30% marca como spoiler
        ];
    }
}
