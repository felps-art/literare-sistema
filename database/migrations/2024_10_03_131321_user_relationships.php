<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //esta tabela é para armazenar as relações de "seguidor/seguido"
        //porque um usuário pode seguir vários outros usuários
        //e um usuário pode ser seguido por outros usuários
        //Nessas condições, em que eu tenho uma relação n-n de banco de dados
        //eu necessito criar uma nova tabela para manter os relacionamentos
        Schema::create('user_relationships', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_id'); //armazeno o id do usuário seguidor
            $table->unsignedBigInteger('followed_id'); //armazeno o id do usuário seguido

            //defino que os dois campos serão índices para a tabela
            //ou seja, não vou poder ter duas tuplas no banco de dados
            //que tenha a mesma relação de "usuário segue usuário"
            $table->unique(['follower_id', 'followed_id']);

            //crio uma chave estrangeira para o campo follower_id com a tabela users
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            
            //crio uma chave estrangeira para o campo followed_id com a tabela users
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
