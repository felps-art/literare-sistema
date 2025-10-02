<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoresTable extends Migration
{
    public function up()
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('biografia')->nullable();
            $table->string('codigo')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('autores');
    }
}