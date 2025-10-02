<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivrosTable extends Migration
{
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('sinopse')->nullable();
            $table->string('codigo_livro')->unique();
            $table->integer('ano_publicacao')->nullable();
            $table->integer('numero_paginas')->nullable();
            $table->string('imagem_capa')->nullable();
            $table->foreignId('editora_id')->constrained('editoras')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livros');
    }
}