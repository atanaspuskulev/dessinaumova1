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
            'product_id' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => trans('errors.product_required'),
            'product_id.numeric' => trans('errors.product_numeric'),
            'product_id.gt' => trans('errors.product_gt'),
            'quantity.required' => trans('errors.quantity_required'),
            'quantity.numeric' => trans('errors.quantity_numeric'),
            'quantity.gt' => trans('errors.quantity_gt'),
        ];
    }
}
