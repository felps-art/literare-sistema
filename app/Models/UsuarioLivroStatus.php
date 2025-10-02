<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioLivroStatus extends Model
{
    use HasFactory;

    protected $table = 'usuario_livro_status';

    protected $fillable = ['user_id', 'livro_id', 'status_leitura_id', 'avaliacao'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livro(): BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }

    public function statusLeitura(): BelongsTo
    {
        return $this->belongsTo(StatusLeitura::class);
    }
}