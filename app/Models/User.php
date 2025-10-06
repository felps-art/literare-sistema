<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Resenha;
use App\Models\UsuarioLivroStatus;
use App\Models\Livro;
use App\Models\ResenhaComment;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Definindo os atributos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_perfil',
        'address',
        'whatsapp',
        'instagram',
        'description_profile',
        'is_admin'
    ];

    // Atributos que devem ser ocultados quando o objeto for convertido para array ou JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Definindo os atributos que serão convertidos para tipos específicos
    protected $casts = [
        'email_verified_at' => 'datetime', // O campo de verificação de e-mail será tratado como um datetime
        'password' => 'hashed', // A senha será automaticamente criptografada
    ];

    /**
     * Relacionamento: um usuário pode ter muitos posts.
     * Este método define a relação com a tabela `posts`.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relacionamento: um usuário pode ter muitos comentários.
     * Este método define a relação com a tabela `comments`.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relacionamento: usuários que seguem o usuário atual.
     * Este método define uma relação de muitos para muitos com a tabela `user_relationships`.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_relationships', 'followed_id', 'follower_id');
    }

    /**
     * Relacionamento: usuários que o usuário atual está seguindo.
     * Este método define uma relação de muitos para muitos com a tabela `user_relationships`.
     */
    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_relationships', 'follower_id', 'followed_id');
    }

    /**
     * Relacionamento: posts que o usuário curtiu.
     * Este método define uma relação de muitos para muitos com a tabela `likes`.
     */
    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }

    /**
     * Relacionamento: um usuário pode ter muitas resenhas.
     * Liga com a tabela `resenhas` pela chave estrangeira `user_id`.
     */
    public function resenhas(): HasMany
    {
        return $this->hasMany(Resenha::class, 'user_id');
    }

    /**
     * Todos os registros de status de leitura deste usuário (pivot)
     */
    public function livrosStatus(): HasMany
    {
        return $this->hasMany(UsuarioLivroStatus::class, 'user_id');
    }

    /**
     * Livros marcados como "Quero Ler" (status_leitura_id = 1)
     */
    public function livrosQueroLer(): HasMany
    {
        return $this->hasMany(UsuarioLivroStatus::class, 'user_id')
            ->where('status_leitura_id', 1);
    }

    /**
     * Livros marcados como "Lendo" (status_leitura_id = 2)
     */
    public function livrosLendo(): HasMany
    {
        return $this->hasMany(UsuarioLivroStatus::class, 'user_id')
            ->where('status_leitura_id', 2);
    }

    /**
     * Livros marcados como "Lidos" (status_leitura_id = 3)
     */
    public function livrosLidos(): HasMany
    {
        return $this->hasMany(UsuarioLivroStatus::class, 'user_id')
            ->where('status_leitura_id', 3);
    }

    /**
     * Comentários feitos em resenhas.
     */
    public function resenhaComments(): HasMany
    {
        return $this->hasMany(ResenhaComment::class, 'user_id');
    }

    /**
     * Resenhas que o usuário curtiu.
     */
    public function likedResenhas(): BelongsToMany
    {
        return $this->belongsToMany(Resenha::class, 'resenha_likes', 'user_id', 'resenha_id')->withTimestamps();
    }

    /**
     * Verifica se este usuário está seguindo outro usuário
     */
    public function isFollowing(User $user): bool
    {
        return $this->follows()->where('followed_id', $user->id)->exists();
    }

    /**
     * Verifica se este usuário é seguido por outro usuário
     */
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Conta total de seguidores
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
    }

    /**
     * Conta total de usuários que está seguindo
     */
    public function followingCount(): int
    {
        return $this->follows()->count();
    }
}
