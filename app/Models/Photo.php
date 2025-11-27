<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['post_id','image_path'];

    // Expor automaticamente o atributo "url" quando o modelo for serializado
    protected $appends = ['url'];

    /**
     * Relacionamento: post ao qual a foto pertence.
     * Uma foto pertence a um único post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Atributo calculado: URL pública da imagem.
     * Regras:
     * - Se for URL absoluta (http/https) ou caminho absoluto (/...), retorna como está.
     * - Se existir no disco 'public' (storage/app/public), usa Storage::url() => /storage/...
     * - Caso contrário, tenta servir de /img/<image_path>; se vazio, fallback para /img/default-post.png
     */
    public function getUrlAttribute(): string
    {
        $path = (string) ($this->image_path ?? '');
        if ($path === '') {
            return asset('img/default-post.png');
        }
        // Caminhos absolutos ou URLs já prontos
        if (Str::startsWith($path, ['http://','https://','/'])) {
            return $path;
        }
        // Verifica no disco público; usa fallback direto /storage/<path> para evitar problemas de APP_URL
        try {
            if (Storage::disk('public')->exists($path)) {
                return '/storage/' . ltrim($path,'/');
            }
        } catch (\Throwable $e) {
            // silencioso
        }
        // Último fallback para pasta de imagens estáticas
        return asset('img/'.$path);
    }
}
