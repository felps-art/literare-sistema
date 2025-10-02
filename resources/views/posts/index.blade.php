@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Posts</h1>
    <a href="{{ route('posts.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Post</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
@endif

@forelse($posts as $post)
    <div class="bg-white p-4 rounded shadow mb-4">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>por <a href="{{ route('profile.show',$post->user_id) }}" class="text-blue-600 hover:underline">{{ $post->user->name }}</a></span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>
        <p class="mb-2 whitespace-pre-line">{{ Str::limit($post->content, 300) }}</p>
        @if($post->photos->count())
            <div class="grid grid-cols-4 gap-2 mb-2">
                @foreach($post->photos->take(4) as $photo)
                    <img src="{{ asset('storage/'.$photo->image_path) }}" class="w-full h-32 object-cover rounded" />
                @endforeach
            </div>
        @endif
        <div class="flex items-center justify-between mt-2">
            <a href="{{ route('posts.show',$post) }}" class="text-blue-600 text-sm hover:underline">
                <i class="fas fa-eye mr-1"></i>Ver mais
            </a>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">
                    <i class="fas fa-comment mr-1"></i>{{ $post->comments->count() }}
                </span>
                @auth
                    @php($liked = $post->likes->where('user_id',auth()->id())->count() > 0)
                    @if($liked)
                        <form action="{{ route('posts.unlike',$post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="flex items-center gap-1 text-red-500 hover:text-red-600 transition-colors">
                                <i class="fas fa-heart"></i>
                                <span class="text-sm">{{ $post->likes_count ?? $post->likes->count() }}</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('posts.like',$post) }}" method="POST" class="inline">
                            @csrf
                            <button class="flex items-center gap-1 text-gray-500 hover:text-red-500 transition-colors">
                                <i class="far fa-heart"></i>
                                <span class="text-sm">{{ $post->likes_count ?? $post->likes->count() }}</span>
                            </button>
                        </form>
                    @endif
                @else
                    <span class="flex items-center gap-1 text-gray-500">
                        <i class="far fa-heart"></i>
                        <span class="text-sm">{{ $post->likes_count ?? $post->likes->count() }}</span>
                    </span>
                @endauth
            </div>
        </div>
    </div>
@empty
    <p class="text-gray-500">Nenhum post encontrado.</p>
@endforelse

<div class="mt-4">{{ $posts->links() }}</div>
@endsection
