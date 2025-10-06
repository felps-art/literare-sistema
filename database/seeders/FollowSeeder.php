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

        // Relações dinâmicas entre usuários recém-criados e os dois primeiros (Tiago e Felipe)
        $emails = [
            'tiago.rios@ibiruba.ifrs.edu.br', // Tiago
            'felipe@felipe', // Felipe
            'ana@ana',
            'cara@cara',
            'rafa@rafa',
            'thigas@thigas',
            'isamel@isamel',
            'gusta@gusta',
            'krammes@krammes',
        ];

        // Map emails to ids (ignore missing)
        $map = [];
        foreach ($emails as $email) {
            $u = User::where('email', $email)->first();
            if ($u) {
                $map[$email] = $u->id;
            }
        }

        // If Tiago and Felipe exist, create mutual follows with others
        $tiagoId = $map['tiago.rios@ibiruba.ifrs.edu.br'] ?? null;
        $felipeId = $map['felipe@felipe'] ?? null;

        foreach ($map as $email => $id) {
            // skip Tiago and Felipe for this loop
            if ($id === $tiagoId || $id === $felipeId) {
                continue;
            }

            // User follows Felipe and Tiago if they exist
            if ($felipeId) {
                DB::table('user_relationships')->updateOrInsert([
                    'follower_id' => $id,
                    'followed_id' => $felipeId,
                ], []);
            }
            if ($tiagoId) {
                DB::table('user_relationships')->updateOrInsert([
                    'follower_id' => $id,
                    'followed_id' => $tiagoId,
                ], []);
            }

            // Felipe follows them back
            if ($felipeId) {
                DB::table('user_relationships')->updateOrInsert([
                    'follower_id' => $felipeId,
                    'followed_id' => $id,
                ], []);
            }
        }

        // Ensure Tiago and Felipe follow each other
        if ($tiagoId && $felipeId) {
            DB::table('user_relationships')->updateOrInsert([
                'follower_id' => $tiagoId,
                'followed_id' => $felipeId,
            ], []);
            DB::table('user_relationships')->updateOrInsert([
                'follower_id' => $felipeId,
                'followed_id' => $tiagoId,
            ], []);
        }
    }
}