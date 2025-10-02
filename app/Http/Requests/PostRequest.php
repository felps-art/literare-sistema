<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'content' => ['required','string','min:3','max:5000'],
            'photos.*' => ['sometimes','image','mimes:jpeg,png,jpg,gif,webp','max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'O conteúdo do post é obrigatório.',
            'content.min' => 'O post precisa ter ao menos :min caracteres.',
            'content.max' => 'O post pode ter no máximo :max caracteres.',
            'photos.*.image' => 'Cada arquivo deve ser uma imagem válida.',
            'photos.*.mimes' => 'Formatos permitidos: jpeg, png, jpg, gif, webp.',
            'photos.*.max' => 'Cada imagem pode ter no máximo 4MB.',
        ];
    }
}
