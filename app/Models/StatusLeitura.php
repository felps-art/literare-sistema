<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusLeitura extends Model
{
    use HasFactory;

    protected $table = 'status_leitura';

    protected $fillable = ['nome', 'descricao'];

    public function usuariosLivros(): HasMany
    {
        return $this->hasMany(UsuarioLivroStatus::class);
    }
}