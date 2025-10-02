<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    /**
     * Relacionamento: o usuário que deu a curtida.
     * Uma curtida pertence a um único usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: o post que recebeu a curtida.
     * Uma curtida pertence a um único post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
