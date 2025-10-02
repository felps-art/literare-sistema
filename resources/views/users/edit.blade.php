@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Editar Perfil</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                <div class="flex items-center space-x-4 mb-2">
                    @if($user->foto_perfil)
                        <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="h-16 w-16 object-cover rounded-full" />
                    @else
                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold">
                            {{ substr($user->name,0,1) }}
                        </div>
                    @endif
                    <input type="file" name="foto_perfil" accept="image/*"
                        class="text-sm text-gray-600" />
                </div>
                <p class="text-xs text-gray-500">Formatos: jpeg, png, jpg, gif. Máx 2MB.</p>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('profile.show', $user->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection
