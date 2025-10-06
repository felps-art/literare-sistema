<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resenha extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'livro_id', 'conteudo', 'avaliacao', 'spoiler'];

    protected static function booted()
    {
        static::created(function(Resenha $resenha){
            try { Activity::log($resenha->user_id, 'resenha_created', $resenha, ['livro_id' => $resenha->livro_id]); } catch (\Throwable $e) { /* silent */ }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livro(): BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ResenhaComment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ResenhaLike::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function likesCount(): int
    {
        return isset($this->attributes['likes_count']) ? (int)$this->attributes['likes_count'] : $this->likes()->count();
    }
}