<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResenhaLike extends Model
{
    use HasFactory;

    protected $fillable = ['resenha_id','user_id'];

    public function resenha(): BelongsTo
    {
        return $this->belongsTo(Resenha::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
