<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'content' => ['required','string','min:2','max:2000']
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'O comentário não pode estar vazio.',
            'content.min' => 'O comentário precisa ter ao menos :min caracteres.',
            'content.max' => 'O comentário pode ter no máximo :max caracteres.'
        ];
    }
}
