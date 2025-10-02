<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Evita duplicar se rodar mais de uma vez
        $email = 'felipe@fernandes.com';

        if (! User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Felipe',
                'email' => $email,
                'password' => 'senha', // será hasheada automaticamente pelo cast 'hashed'
                'image_profile' => null,
                'address' => null,
                'whatsapp' => null,
                'instagram' => null,
                'description_profile' => 'Usuário de demonstração criado pelo seeder.'
            ]);
        }
    }
}
