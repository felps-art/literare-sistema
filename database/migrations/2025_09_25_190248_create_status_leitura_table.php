<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusLeituraTable extends Migration
{
    public function up()
    {
        Schema::create('status_leitura', function (Blueprint $table) { // SINGULAR
            $table->id();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_leitura'); 
    }
}