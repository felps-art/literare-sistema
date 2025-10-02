<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResenhasTable extends Migration
{
    public function up()
    {
        Schema::create('resenhas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->text('conteudo');
            $table->integer('avaliacao')->nullable();
            $table->boolean('spoiler')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resenhas');
    }
}