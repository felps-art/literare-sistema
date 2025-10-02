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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();                           //crio o id do comentário
            $table->text('content');                //conteúdo do comentário
            $table->unsignedBigInteger('user_id');  //armazeno o id do usuário que fez o comentário
            $table->unsignedBigInteger('post_id');  //armazeno o id do post que pertence este comentário
            $table->timestamps();

            //crio uma chave estrangeira entre o campo user_id e a tabela users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            //crio uma chave estrangeira entre o campo post_id e a tabela posts
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
