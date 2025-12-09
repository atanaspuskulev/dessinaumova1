<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberUtil;

class PhoneValidation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! str_starts_with($value, '+')) {
            $fail('The :attribute must include an international country code (start with +).');
            return;
        }
        $util = PhoneNumberUtil::getInstance();
        $regions = array_column(config('countries'), 'short_name');

        foreach ($regions as $region) {
            try {
                $number = $util->parse($value, $region);

                if ($util->isValidNumber($number)) {
                    return; // VALID → stop validation without failing
                }
            } catch (\Exception $e) {
                // ignore parse errors and continue checking next region
            }
        }

        // If we reach here → no region matched
        $fail('The :attribute number is invalid.');
    }
}
