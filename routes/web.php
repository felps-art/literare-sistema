<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResenhaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResenhaCommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\ResenhaCommentLikeController;
use App\Http\Controllers\EstanteController;
use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;

// Página inicial e dashboard principal
Route::get('/', function () {
    // Redireciona usuários logados não-admins para Início
    if (auth()->check() && !auth()->user()->is_admin) {
        return redirect()->route('feed.index');
    }
    return app(DashboardController::class)->index(request());
})->name('dashboard.home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Perfil de usuários
Route::get('/usuarios', [UserProfileController::class, 'index'])->name('users.index');
Route::get('/usuario/{id}', [UserProfileController::class, 'show'])->name('profile.show');
Route::get('/usuario/{id}/posts', [UserProfileController::class, 'posts'])->name('user.posts');

// Rotas de perfil do usuário logado
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil/editar', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil/atualizar', [UserProfileController::class, 'update'])->name('profile.update');
});

// Resenhas (Posts)
Route::resource('resenhas', ResenhaController::class)->middleware(['auth']);
// Comentários em resenhas
Route::post('resenhas/{resenha}/comments',[ResenhaCommentController::class,'store'])->middleware(['auth'])->name('resenhas.comments.store');
Route::delete('resenha-comments/{comment}',[ResenhaCommentController::class,'destroy'])->middleware(['auth'])->name('resenha-comments.destroy');

// Likes em posts
Route::post('posts/{post}/like',[LikeController::class,'store'])->middleware(['auth'])->name('posts.like');
Route::delete('posts/{post}/like',[LikeController::class,'destroy'])->middleware(['auth'])->name('posts.unlike');

// Likes em resenhas
Route::post('resenhas/{resenha}/like',[App\Http\Controllers\ResenhaLikeController::class,'store'])->middleware(['auth'])->name('resenhas.like');
Route::delete('resenhas/{resenha}/like',[App\Http\Controllers\ResenhaLikeController::class,'destroy'])->middleware(['auth'])->name('resenhas.unlike');

// Likes em comentários
Route::post('comments/{comment}/like',[CommentLikeController::class,'store'])->middleware(['auth'])->name('comments.like');
Route::delete('comments/{comment}/like',[CommentLikeController::class,'destroy'])->middleware(['auth'])->name('comments.unlike');
Route::post('resenha-comments/{comment}/like',[ResenhaCommentLikeController::class,'store'])->middleware(['auth'])->name('resenha-comments.like');
Route::delete('resenha-comments/{comment}/like',[ResenhaCommentLikeController::class,'destroy'])->middleware(['auth'])->name('resenha-comments.unlike');

// Sistema Follow/Unfollow
Route::post('users/{user}/follow',[App\Http\Controllers\FollowController::class,'store'])->middleware(['auth'])->name('users.follow');
Route::delete('users/{user}/unfollow',[App\Http\Controllers\FollowController::class,'destroy'])->middleware(['auth'])->name('users.unfollow');
Route::get('users/{user}/followers',[App\Http\Controllers\FollowController::class,'followers'])->name('users.followers');
Route::get('users/{user}/following',[App\Http\Controllers\FollowController::class,'following'])->name('users.following');

// Outros recursos
// Início (feed personalizado)
Route::get('/feed', [FeedController::class,'index'])->middleware(['auth'])->name('feed.index');
// Explorar (feed geral, sem personalização)
Route::get('/explorar', [FeedController::class,'explore'])->middleware(['auth'])->name('explorar');
Route::resource('livros', LivroController::class);
Route::resource('autores', AutorController::class);
Route::resource('editoras', EditoraController::class);
Route::resource('posts', PostController::class)->middleware(['auth']);
// Estante (status de leitura e avaliação)
Route::post('livros/{livro}/estante', [EstanteController::class, 'store'])->middleware(['auth'])->name('livros.estante.store');
Route::delete('livros/{livro}/estante', [EstanteController::class, 'destroy'])->middleware(['auth'])->name('livros.estante.destroy');
// Estante do usuário
Route::get('/estante', [EstanteController::class, 'index'])->middleware(['auth'])->name('estante.index');
// Comentários em posts
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->middleware(['auth'])->name('posts.comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->middleware(['auth'])->name('comments.destroy');

// Rota de fallback para SPA (se estiver usando Vue/React)
Route::get('/{any}', function () {
    return view('dashboard');
})->where('any', '.*');