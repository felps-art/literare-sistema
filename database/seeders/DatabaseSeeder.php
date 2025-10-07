<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            StatusLeituraSeeder::class,
            EditoraSeeder::class,
            AutorSeeder::class,
            LivroSeeder::class,
            UserTableSeeder::class, // garante usuários principais
            PostSeeder::class,
            ResenhaSeeder::class,
            PhotosTableSeeder::class,
            LikesTableSeeder::class,
            FollowSeeder::class,
        ]);
    }
}