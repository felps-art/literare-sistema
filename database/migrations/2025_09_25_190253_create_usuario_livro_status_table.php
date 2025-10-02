<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioLivroStatusTable extends Migration
{
    public function up()
    {
        Schema::create('usuario_livro_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->foreignId('status_leitura_id')->constrained('status_leitura')->onDelete('cascade');
            $table->integer('avaliacao')->nullable()->comment('Nota de 1 a 5');
            $table->timestamps();
            
            $table->unique(['user_id', 'livro_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_livro_status');
    }
}