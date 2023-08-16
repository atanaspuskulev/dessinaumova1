<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'title' => 'required|unique:products,title' . (request()->has('product_id') ? ',' . request()->product_id : ''),
            'short_description' => 'required',
            'description' =>'required',
            'price' =>'required',
            'material' => 'required',
            'dimentions1' => 'required',
            'delivery' => 'present',
            'sold' => 'sometimes',
            'meta_title' => 'present',
            'meta_keywords' => 'present',
            'meta_description' => 'present',
            'images.*' => 'file|mimes:jpeg,png'
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Category is required',
            'title.required' => 'Title is required',
            'title.unique' => 'There is already a product with that name',            'short_description.required' => 'Short description is required',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',
            'material.required' => 'Material is required',
            'dimentions1.required' => 'Size is required'
        ];
    }
}
