@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
        <input type="text" name="titulo" value="{{ old('titulo', $livro->titulo ?? '') }}" required
               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        @error('titulo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Código (ISBN / interno) *</label>
        <input type="text" name="codigo_livro" value="{{ old('codigo_livro', $livro->codigo_livro ?? '') }}" required
               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        @error('codigo_livro')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ano Publicação</label>
        <input type="number" name="ano_publicacao" value="{{ old('ano_publicacao', $livro->ano_publicacao ?? '') }}"
               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        @error('ano_publicacao')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Páginas</label>
        <input type="number" name="numero_paginas" value="{{ old('numero_paginas', $livro->numero_paginas ?? '') }}"
               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        @error('numero_paginas')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Editora *</label>
        <select name="editora_id" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">Selecione</option>
            @foreach($editoras as $editora)
                <option value="{{ $editora->id }}" @selected(old('editora_id', $livro->editora_id ?? '') == $editora->id)>{{ $editora->nome }}</option>
            @endforeach
        </select>
        @error('editora_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Autores *</label>
        <select name="autores[]" multiple required size="5" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @php $selectedAutores = old('autores', isset($livro) ? $livro->autores->pluck('id')->toArray() : []); @endphp
            @foreach($autores as $autor)
                <option value="{{ $autor->id }}" @selected(in_array($autor->id, $selectedAutores))>{{ $autor->nome }}</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Segure CTRL (ou CMD) para selecionar múltiplos.</p>
        @error('autores')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Sinopse</label>
        <textarea name="sinopse" rows="5" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('sinopse', $livro->sinopse ?? '') }}</textarea>
        @error('sinopse')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Imagem da Capa</label>
        <input type="file" name="imagem_capa" accept="image/*" class="block w-full text-sm" />
        @if(isset($livro) && $livro->imagem_capa)
            <img src="{{ asset('storage/' . $livro->imagem_capa) }}" class="h-24 mt-2 rounded shadow" />
        @endif
        @error('imagem_capa')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
</div>
<div class="mt-6 flex justify-end space-x-3">
    <a href="{{ route('livros.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
</div>
