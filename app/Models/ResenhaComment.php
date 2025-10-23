<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResenhaComment extends Model
{
    use HasFactory;

    protected $fillable = ['resenha_id','user_id','content'];

    public function resenha(): BelongsTo
    {
        return $this->belongsTo(Resenha::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Curtidas deste comentário de resenha.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ResenhaCommentLike::class, 'resenha_comment_id');
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}
