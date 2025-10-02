<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use \App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //crio um usuário com os meus dados para eu testar a aplicação
        User::create([
            'name' => 'Tiago Rios da Rocha',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Professor IFRS - Ibirubá',
            'address' => "Ibirubá",
            'whatsapp' => "999999999",
            'instagram' => "@tiagoriosrocha",
            'email' => 'tiago.rios@ibiruba.ifrs.edu.br',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // Usuário Felipe
        User::create([
            'name' => 'felipe',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => "São Paulo",
            'whatsapp' => "11999999999",
            'instagram' => "@felipe",
            'email' => 'felipe@felipe',
            'email_verified_at' => now(),
            'password' => bcrypt('felipe123'),
            'remember_token' => Str::random(10),
        ]);

    }
}
