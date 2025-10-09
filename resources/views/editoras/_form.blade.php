@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Nome *</label>
        <input type="text" name="nome" value="{{ old('nome', $editora->nome ?? '') }}" class="w-full border rounded p-2" required>
        @error('nome')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>
</div>
<div class="mt-6 flex gap-2">
    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ isset($editora) ? route('editoras.show',$editora) : route('editoras.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
    @else
        <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded">Cancelar</a>
    @endif
</div>
