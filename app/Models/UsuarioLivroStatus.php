<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioLivroStatus extends Model
{
    use HasFactory;

    protected $table = 'usuario_livro_status';

    protected $fillable = ['user_id', 'livro_id', 'status_leitura_id', 'avaliacao'];

    protected static function booted()
    {
        static::created(function(UsuarioLivroStatus $uls){
            try {
                Activity::log($uls->user_id, 'reading_progress_created', $uls, [
                    'livro_id' => $uls->livro_id,
                    'status_leitura_id' => $uls->status_leitura_id,
                    'avaliacao' => $uls->avaliacao,
                ]);
            } catch (\Throwable $e) { /* silent */ }
        });

        static::updated(function(UsuarioLivroStatus $uls){
            if (!$uls->wasChanged(['status_leitura_id','avaliacao'])) {
                return; // evita ruído
            }
            try {
                Activity::log($uls->user_id, 'reading_progress_updated', $uls, [
                    'livro_id' => $uls->livro_id,
                    'status_leitura_id' => $uls->status_leitura_id,
                    'avaliacao' => $uls->avaliacao,
                ]);
            } catch (\Throwable $e) { /* silent */ }
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

    public function statusLeitura(): BelongsTo
    {
        return $this->belongsTo(StatusLeitura::class);
    }
}