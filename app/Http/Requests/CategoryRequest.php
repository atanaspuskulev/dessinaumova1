<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            'title' => 'required|unique:categories,title' . (request()->has('category_id') ? ',' . request()->category_id : ''),
            'description' => 'present',
            'meta_description' => 'present',
            'meta_keywords' => 'present',
            'meta_title' => 'present',
            'is_active' => 'sometimes'
        ];

        $rules['slug'] = $this->has('category_id')
            ? 'required|unique:categories,slug,' . $this->input('category_id')
            : 'present|unique:categories,slug';

        return $rules;
    }
}
