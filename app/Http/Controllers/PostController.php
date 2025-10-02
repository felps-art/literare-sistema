<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{

    public function index(): View
    {
        $posts = Post::with(['user','photos','likes'])
            ->latest()
            ->paginate(15);
        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $post = Post::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('posts','public');
                Photo::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post criado com sucesso.');
    }

    public function show(Post $post): View
    {
        $post->load(['user','photos','comments.user','likes']);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->authorizeOwner($post);
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $this->authorizeOwner($post);
        $post->update(['content' => $request->content]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('posts','public');
                Photo::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post atualizado.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorizeOwner($post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post excluído.');
    }

    protected function authorizeOwner(Post $post): void
    {
        if ($post->user_id !== Auth::id()) {
            abort(403,'Ação não autorizada.');
        }
    }
}
