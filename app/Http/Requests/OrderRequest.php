<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'payer_city' => 'required',
            'payer_zip' => 'required|numeric',
            'payer_address' => 'required',
            'payer_name' => 'required',
            'payer_email' => 'required|email',
            'payer_phone' => 'nullable|numeric',
            'additional_information' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'payer_city.required' => 'Населено място е задължително.',
            'payer_zip.required' => 'Пощенски код е задължителен.',
            'payer_zip.numeric' => 'Пощенски код трябва да е само от числа.',
            'payer_address.required' => 'Адрес за доставка е задължителен.',
            'payer_name.required' => 'Не сте попълнили име.',
            'payer_email.required' => 'Email адресът е задължителен.',
            'payer_email.email' => 'Email адресът не е валиден.',
            'payer_phone.required' => 'Телефон е задължително поле.',
            'payer_phone.numeric' => 'Телефона трябва да е само от числа.',
        ];
    }
}
