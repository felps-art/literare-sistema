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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                                 //armazena o id do post
            $table->text('content');                      //armazena o conteúdo do post
            $table->unsignedBigInteger('user_id');        //armazena o id do dono do post
            $table->integer('likes_count')->default(0);   //pode armazenar a contagem de likes do post
            $table->timestamps();                         //armazena a data de criação e atualização do post

            //crio uma chave estrangeira entre o campo user_id e a tabela users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
