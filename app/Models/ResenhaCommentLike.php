<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResenhaCommentLike extends Model
{
    use HasFactory;

    protected $fillable = ['resenha_comment_id', 'user_id'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(ResenhaComment::class, 'resenha_comment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
