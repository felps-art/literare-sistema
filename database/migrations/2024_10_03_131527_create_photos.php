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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();                           //armazeno o id da uma foto/mídia
            $table->unsignedBigInteger('post_id');  //armazeno o id do post que esta foto/mídia pertence
            $table->string('image_path');           //armazeno o caminho/nome da foto/mídia
            $table->timestamps();                   //armazeno a data de criação e edição da foto/mídia

            //crio uma chave estrangeira entre o campo post_id e a tabela posts
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
