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
        if (Str::startsWith($path, ['http://','https://','/'])) {
            return $path;
        }
        // Se existir no disco público
        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::url($path);
            }
        } catch (\Throwable $e) {
            // ignora e segue para fallback
        }
        // Fallback para /img/<arquivo> (padrões do projeto ficam em public/img)
        return asset('img/'.$path);
    }
}
