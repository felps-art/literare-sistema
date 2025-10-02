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
        //Esta tablela irá manter uma relação de "curtida"
        //em que um usuário poderá curtir vários posts
        //e um post poderá ser curtido por vários usuários
        //nessas condições, em que há uma relação n-n no banco de dados
        //eu necessito criar uma nova tabela para manter a relação
        Schema::create('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');  //crio um campo para armazenar o id do usuário que curtiu
            $table->unsignedBigInteger('post_id');  //crio um campo para armazenar o id do post que foi curtido
            $table->timestamps();                   //armazeno a data de criação e edição

            //defino que os dois campos serão índices para a tabela
            //ou seja, não vou poder ter duas tuplas no banco de dados
            //que tenha a mesma relação de "usuário curte post"
            $table->unique(['user_id', 'post_id']);

            //crio uma chave estrangeira para o campo post_id referenciando a tabela posts
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            //crio uma chave estrangeira para o campo user_id referenciando a tabela users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
