<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryInformationRequest extends FormRequest
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
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'delivery_address' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|numeric',
            'additional_information' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'country' => 'Country is required',
            'state' => 'State is required',
            'city' => 'City is required',
            'zip' => 'Zip/Postal Code is required',
            'delivery_address' => 'Delivery Address is required',
            'name' => 'Full Name is required',
            'email' => 'Email is required',
        ];
    }
}
