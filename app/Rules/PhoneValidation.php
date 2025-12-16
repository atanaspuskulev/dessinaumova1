<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberUtil;

class PhoneValidation implements ValidationRule
{
    protected string|null $region;

    public function __construct(string|null $region)
    {
        $this->region = $region !== null ? strtoupper($region) : null;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $util = PhoneNumberUtil::getInstance();

        if($this->region === null) {
            $fail('Невалиден код.');
            return;
        }

        try {
            $number = $util->parse($value, $this->region);

            if (! $util->isValidNumber($number)) {
                $fail('Невалиден телефонен номер.');
            }
        } catch (\Exception $e) {
            $fail('Невалиден телефонен номер.');
        }
    }
}
