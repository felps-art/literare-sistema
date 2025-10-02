<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReacaoOpiniao extends Model
{
    use HasFactory;

    protected $table = 'reacao_opiniao';

    protected $fillable = ['user_id', 'livro_id', 'conteudo', 'tipo', 'pagina'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livro(): BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }
}