<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CartAddRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|numeric|gt:0'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.numeric' => 'The product ID must be a numeric value.',
            'product_id.gt' => 'The product ID is not valid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
        }

        parent::failedValidation($validator);
    }
}
