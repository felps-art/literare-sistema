<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenha_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resenha_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('resenha_id')->references('id')->on('resenhas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['resenha_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenha_comments');
    }
};
