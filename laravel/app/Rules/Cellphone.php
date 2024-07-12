<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cellphone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->validateCellPhone($value)) {
            $fail('O número do celular deve ser válido.');
        }
    }

    private function validateCellPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        return strlen($phone) == 11;
    }
}
