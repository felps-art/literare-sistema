@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
        <input type="text" name="nome" value="{{ old('nome', $autor->nome ?? '') }}" required
               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        @error('nome')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
        <input type="text" name="codigo" value="{{ old('codigo', $autor->codigo ?? '') }}" required
               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
        @error('codigo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Biografia</label>
        <textarea name="biografia" rows="6" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('biografia', $autor->biografia ?? '') }}</textarea>
        @error('biografia')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
</div>
<div class="mt-6 flex justify-end space-x-3">
    <a href="{{ route('autores.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
</div>
