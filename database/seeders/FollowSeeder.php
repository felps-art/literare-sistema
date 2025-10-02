<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->count() < 2) {
            return; // Precisa de pelo menos 2 usuários para criar relacionamentos
        }

        // Criar alguns relacionamentos de follow de exemplo
        $relationships = [
            // Felipe segue outros usuários
            ['follower_id' => 2, 'followed_id' => 1], // Felipe segue Tiago
            
            // Tiago segue Felipe de volta
            ['follower_id' => 1, 'followed_id' => 2], // Tiago segue Felipe
        ];

        foreach ($relationships as $relationship) {
            // Verificar se os usuários existem e se o relacionamento já não existe
            if (User::find($relationship['follower_id']) && 
                User::find($relationship['followed_id']) &&
                !DB::table('user_relationships')
                    ->where('follower_id', $relationship['follower_id'])
                    ->where('followed_id', $relationship['followed_id'])
                    ->exists()) {
                
                DB::table('user_relationships')->insert($relationship);
            }
        }
    }
}