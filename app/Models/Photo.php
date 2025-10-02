<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    /**
     * Relacionamento: post ao qual a foto pertence.
     * Uma foto pertence a um único post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
