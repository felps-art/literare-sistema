<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pode adicionar lógica de autorização mais específica aqui
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $livroId = $this->route('livro'); // usado para ignorar unique no update

        return [
            'titulo' => 'required|string|max:255',
            'sinopse' => 'nullable|string',
            'codigo_livro' => 'required|unique:livros,codigo_livro' . ($livroId ? (',' . $livroId) : ''),
            'ano_publicacao' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'editora_id' => 'required|exists:editoras,id',
            'autores' => 'required|array',
            'autores.*' => 'exists:autores,id',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'codigo_livro.required' => 'O código do livro é obrigatório.',
            'codigo_livro.unique' => 'Este código já está em uso.',
            'editora_id.required' => 'Selecione uma editora.',
            'autores.required' => 'Informe pelo menos um autor.',
            'imagem_capa.image' => 'O arquivo deve ser uma imagem válida.'
        ];
    }
}
