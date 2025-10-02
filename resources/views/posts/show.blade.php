@extends('layouts.app')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Post de <a href="{{ route('profile.show',$post->user_id) }}" class="text-blue-600 hover:underline">{{ $post->user->name }}</a></h1>
    <div class="flex gap-2">
        @if($post->user_id === auth()->id())
            <a href="{{ route('posts.edit',$post) }}" class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
            <form action="{{ route('posts.destroy',$post) }}" method="POST" onsubmit="return confirm('Excluir este post?');">
                @csrf
                @method('DELETE')
                <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">Excluir</button>
            </form>
        @endif
        <a href="{{ route('posts.index') }}" class="px-3 py-2 border rounded">Voltar</a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
@endif

<p class="whitespace-pre-line mb-4">{{ $post->content }}</p>

@auth
    <div class="mb-6 flex items-center gap-4">
        @php($liked = $post->isLikedBy(auth()->user()))
        @if($liked)
            <form action="{{ route('posts.unlike',$post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="flex items-center gap-2 text-red-500 hover:text-red-600 transition-colors" title="Remover curtida">
                    <i class="fas fa-heart text-lg"></i>
                    <span class="font-medium">{{ $post->likesCount() }}</span>
                </button>
            </form>
        @else
            <form action="{{ route('posts.like',$post) }}" method="POST">
                @csrf
                <button class="flex items-center gap-2 text-gray-500 hover:text-red-500 transition-colors" title="Curtir">
                    <i class="far fa-heart text-lg"></i>
                    <span class="font-medium">{{ $post->likesCount() }}</span>
                </button>
            </form>
        @endif
    </div>
@else
    <div class="mb-6 flex items-center gap-2 text-sm text-gray-600">
        <i class="far fa-heart"></i>
        <span>{{ $post->likesCount() }} curtida{{ $post->likesCount() === 1 ? '' : 's' }}</span>
        <span>•</span>
        <a href="{{ route('login') }}" class="text-blue-600 underline">Entre para curtir</a>
    </div>
@endauth

@if($post->photos->count())
    <div class="grid grid-cols-4 gap-3 mb-6">
        @foreach($post->photos as $photo)
            <img src="{{ asset('storage/'.$photo->image_path) }}" class="w-full h-40 object-cover rounded" />
        @endforeach
    </div>
@endif

<h2 class="font-semibold mb-2">Comentários ({{ $post->comments->count() }})</h2>
<div class="space-y-4 mb-6">
    @forelse($post->comments as $comment)
        <div class="bg-gray-50 p-3 rounded">
            <div class="flex justify-between items-start mb-1">
                <div class="text-sm text-gray-600">{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</div>
                @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $post->user_id))
                    <form action="{{ route('comments.destroy',$comment) }}" method="POST" onsubmit="return confirm('Remover este comentário?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs text-red-600 hover:underline">Remover</button>
                    </form>
                @endif
            </div>
            <p>{{ $comment->content }}</p>
        </div>
    @empty
        <p class="text-gray-500">Nenhum comentário ainda.</p>
    @endforelse
</div>

@auth
<form action="{{ route('posts.comments.store',$post) }}" method="POST" class="bg-white p-4 rounded shadow">
    @csrf
    <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Escreva um comentário..." required>{{ old('content') }}</textarea>
    @error('content')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    <button class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Comentar</button>
</form>
@else
<p class="text-sm text-gray-600">Faça <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> para comentar.</p>
@endauth
@endsection
