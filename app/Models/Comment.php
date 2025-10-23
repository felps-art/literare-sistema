<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = ['content', 'user_id', 'post_id'];

    /**
     * Relacionamento: o usuário que fez o comentário.
     * Um comentário pertence a um único usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: o post que foi comentado.
     * Um comentário pertence a um único post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Curtidas recebidas por este comentário.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Verifica se foi curtido por um usuário.
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Quantidade de curtidas.
     */
    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}

