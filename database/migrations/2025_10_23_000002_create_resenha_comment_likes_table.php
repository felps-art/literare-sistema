<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resenha_comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resenha_comment_id')->constrained('resenha_comments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['resenha_comment_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenha_comment_likes');
    }
};
