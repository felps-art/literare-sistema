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
        // Usuário administrador
        User::updateOrCreate([
            'email' => 'felipe@felipe',
        ], [
            'name' => 'felipe',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => "São Paulo",
            'whatsapp' => "11999999999",
            'instagram' => "@felipe",
            'email_verified_at' => now(),
            'password' => bcrypt('felipe123'),
            'is_admin' => true,
            'remember_token' => Str::random(10),
        ]);

        // Usuário administrador
        User::updateOrCreate([
            'email' => 'ana@ana',
        ], [
            'name' => 'ana',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade A',
            'whatsapp' => '11990000001',
            'instagram' => '@ana',
            'email_verified_at' => now(),
            'password' => bcrypt('ana123'),
            'is_admin' => true,
            'remember_token' => Str::random(10),
        ]);

        // Outros usuários (padronizados)
        User::updateOrCreate([
            'email' => 'cara@cara',
        ], [
            'name' => 'çara',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade B',
            'whatsapp' => '11990000002',
            'instagram' => '@cara',
            'email_verified_at' => now(),
            'password' => bcrypt('çara123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate([
            'email' => 'rafa@rafa',
        ], [
            'name' => 'rafa',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade C',
            'whatsapp' => '11990000003',
            'instagram' => '@rafa',
            'email_verified_at' => now(),
            'password' => bcrypt('rafa123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate([
            'email' => 'thigas@thigas',
        ], [
            'name' => 'thigas',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade D',
            'whatsapp' => '11990000004',
            'instagram' => '@thigas',
            'email_verified_at' => now(),
            'password' => bcrypt('thigas123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate([
            'email' => 'isamel@isamel',
        ], [
            'name' => 'isamel',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade E',
            'whatsapp' => '11990000005',
            'instagram' => '@isamel',
            'email_verified_at' => now(),
            'password' => bcrypt('isamel123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate([
            'email' => 'gusta@gusta',
        ], [
            'name' => 'gusta',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade F',
            'whatsapp' => '11990000006',
            'instagram' => '@gusta',
            'email_verified_at' => now(),
            'password' => bcrypt('gusta123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate([
            'email' => 'krammes@krammes',
        ], [
            'name' => 'krammes',
            'image_profile' => 'default-user.png',
            'description_profile' => 'Usuário teste',
            'address' => 'Cidade G',
            'whatsapp' => '11990000007',
            'instagram' => '@krammes',
            'email_verified_at' => now(),
            'password' => bcrypt('krammes123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

    }
}
