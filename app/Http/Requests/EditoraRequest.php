<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajustar se houver políticas de acesso
    }

    public function rules(): array
    {
        $editoraId = $this->route('editora')?->id ?? $this->route('editora');

        return [
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('editoras', 'nome')->ignore($editoraId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da editora é obrigatório.',
            'nome.unique' => 'Já existe uma editora com este nome.',
            'nome.max' => 'O nome pode ter no máximo 255 caracteres.',
        ];
    }
}
