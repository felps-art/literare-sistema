@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold">Escrever Nova Resenha</h1>
        </div>

        <form action="{{ route('resenhas.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Seleção do livro -->
            <div class="mb-6">
                <label for="livro_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Selecione o Livro *
                </label>
                <select name="livro_id" id="livro_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecione um livro...</option>
                    @foreach($livros as $livro)
                        <option value="{{ $livro->id }}" {{ old('livro_id') == $livro->id ? 'selected' : '' }}>
                            {{ $livro->titulo }} 
                            @if($livro->autores->count() > 0)
                                - {{ $livro->autores->first()->nome }}
                            @endif
                            ({{ $livro->ano_publicacao }})
                        </option>
                    @endforeach
                </select>
                @error('livro_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Avaliação -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Sua Avaliação
                </label>
                <div class="flex space-x-1" id="avaliacao-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                class="text-2xl focus:outline-none"
                                data-rating="{{ $i }}"
                                onclick="setRating({{ $i }})">
                            <span id="star-{{ $i }}">☆</span>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="avaliacao" id="avaliacao" value="{{ old('avaliacao', 0) }}">
                @error('avaliacao')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Conteúdo da resenha -->
            <div class="mb-6">
                <label for="conteudo" class="block text-sm font-medium text-gray-700 mb-2">
                    Sua Resenha *
                </label>
                <textarea name="conteudo" id="conteudo" rows="12" required
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Compartilhe suas impressões sobre o livro...">{{ old('conteudo') }}</textarea>
                @error('conteudo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Spoiler -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="spoiler" value="1" 
                           {{ old('spoiler') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Esta resenha contém spoilers</span>
                </label>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('resenhas.index') }}" 
                   class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Publicar Resenha
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setRating(rating) {
    // Atualizar estrelas visuais
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star-' + i);
        if (i <= rating) {
            star.textContent = '★';
            star.className = 'text-yellow-400';
        } else {
            star.textContent = '☆';
            star.className = 'text-gray-300';
        }
    }
    
    // Atualizar campo hidden
    document.getElementById('avaliacao').value = rating;
}

// Inicializar estrelas com valor antigo (se houver)
document.addEventListener('DOMContentLoaded', function() {
    const oldRating = {{ old('avaliacao', 0) }};
    if (oldRating > 0) {
        setRating(oldRating);
    }
});
</script>
@endsection