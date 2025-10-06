<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class SeguidorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //pego a lista de usuários
        $listaUsuarios = User::all();
        
        //faço um laço de repetição em que para cada usuário
        //eu faço o vínculo com uma série de outros usuários
        //pra eu criar o relacionamento de seguindo/seguidores
        foreach ($listaUsuarios as $umUsuario) {
            // prepare an array of other user ids (exclude self)
            $possible = $listaUsuarios->where('id', '!=', $umUsuario->id)->pluck('id')->all();
            $countPossible = count($possible);
            if ($countPossible === 0) {
                continue;
            }

            // choose between 1 and min(3, countPossible) random ids
            $pick = rand(1, min(3, $countPossible));
            shuffle($possible);
            $randomIds = array_slice($possible, 0, $pick);

            // attach without duplicating existing relationships
            $umUsuario->follows()->syncWithoutDetaching($randomIds);
        }
    }
}
