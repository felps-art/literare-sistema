<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Definir o locale como 'pt_BR' para Faker
        $faker = \Faker\Factory::create('pt_BR');

        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $name = $firstName . ' ' . $lastName;
        $email = strtolower($firstName . "_" . $lastName . "@ibiruba.ifrs.edu.br");
        $instagram = strtolower('@' . $firstName . "_". $lastName);

        return [
            'name' => $name,
            'email' => $email,
            'description_profile' => $faker->sentence,
            'address' => $faker->address,
            'whatsapp' => $faker->phone,
            'instagram' => $instagram,
            'email_verified_at' => now(),
            'image_profile' => 'default-user.png',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
