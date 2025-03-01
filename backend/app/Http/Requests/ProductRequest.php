<?php

namespace App\Http\Requests;

use App\Helpers\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'image_url' => 'required|url',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'O campo name é obrigatório.',
            'name.string' => 'O campo name deve ser uma string.',
            'name.max' => 'O campo name não deve exceder 100 caracteres.',
            'description.required' => 'O campo description é obrigatório.',
            'description.string' => 'O campo description deve ser uma string.',
            'image_url.required' => 'O campo image_url é obrigatório.',
            'image_url.url' => 'O campo image_url deve ser uma URL válida.',
            'price.required' => 'O campo price é obrigatório.',
            'price.numeric' => 'O campo price deve ser um número.',
            'category_id.required' => 'O campo category_id é obrigatório.',
            'category_id.exists' => 'O campo category_id selecionado é inválido ou não existe.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        ValidationHelper::handleFailedValidation($validator);
    }
}
