<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'sinopse', 'codigo_livro', 'ano_publicacao', 
        'numero_paginas', 'imagem_capa', 'editora_id'
    ];

    // Relacionamentos
    public function editora(): BelongsTo
    {
        return $this->belongsTo(Editora::class);
    }

    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'livro_autor');
    }

    public function resenhas(): HasMany
    {
        return $this->hasMany(Resenha::class);
    }

    public function reacoesOpinioes(): HasMany
    {
        return $this->hasMany(ReacaoOpiniao::class);
    }

    public function usuariosStatus(): HasMany
    {
        return $this->hasMany(UsuarioLivroStatus::class);
    }
}