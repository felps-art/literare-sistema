<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $autorId = $this->route('autore') ?? $this->route('autor'); // fallback
        return [
            'nome' => 'required|string|max:255',
            'codigo' => 'required|string|max:100|unique:autores,codigo' . ($autorId ? (',' . $autorId) : ''),
            'biografia' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'codigo.required' => 'O código é obrigatório.',
            'codigo.unique' => 'Este código já está cadastrado.'
        ];
    }
}
