<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReacaoOpiniaoTable extends Migration
{
    public function up()
    {
        Schema::create('reacao_opiniao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->text('conteudo');
            $table->string('tipo'); // 'reacao', 'opiniao'
            $table->integer('pagina')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reacao_opiniao');
    }
}