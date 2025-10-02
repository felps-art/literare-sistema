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
        foreach($listaUsuarios as $umUsuario){
            $umUsuario->follows()->attach($listaUsuarios->random(rand(3,$listaUsuarios->count()-1)));
        }
    }
}
