<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidation;
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
            'payer_country' => 'required',
            'payer_city' => 'required',
            'payer_zip' => 'required',
            'payer_address' => 'required',
            'payer_name' => 'required',
            'payer_email' => 'required|email',
            'payer_phone' => ['required', new PhoneValidation($this->payer_country),],
            'additional_information' => 'nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->phone_code && $this->payer_phone) {
            $this->merge([
                'payer_phone' => $this->phone_code . $this->payer_phone,
            ]);
        }
    }

    public function messages()
    {
        return [
            'payer_country.required' => 'Моля, изберете държава',
            'payer_city.required' => 'Моля, въведете населено място',
            'payer_zip.required' => 'Моля, въведете пощенски код',
            'payer_zip.numeric' => 'Пощенски код трябва да е само от числа.',
            'payer_address.required' => 'Моля въведете адрес за доставка',
            'payer_name.required' => 'Моля, попълнете вашето име',
            'payer_email.required' => 'Моля, попълете вашият e-mail адрес',
            'payer_email.email' => 'Email адресът не е валиден.',
            'payer_phone.required' => 'Телефон е задължително поле.',
            'payer_phone.numeric' => 'Телефона трябва да е само от числа.',
        ];
    }
}
