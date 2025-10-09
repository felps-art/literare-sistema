@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Conteúdo *</label>
        <textarea name="content" rows="4" class="w-full border rounded p-2" required>{{ old('content', $post->content ?? '') }}</textarea>
        @error('content')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Fotos (opcional)</label>
        <input type="file" name="photos[]" multiple accept="image/*" class="w-full border rounded p-2">
        @error('photos.*')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        @if(isset($post) && $post->photos->count())
            <div class="mt-3 grid grid-cols-3 gap-2">
                @foreach($post->photos as $photo)
                    <img src="{{ $photo->url }}" class="h-24 w-full object-cover rounded" />
                @endforeach
            </div>
        @endif
    </div>
</div>
<div class="mt-6 flex gap-2">
    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
    <a href="{{ isset($post) ? route('posts.show',$post) : route('posts.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
</div>
