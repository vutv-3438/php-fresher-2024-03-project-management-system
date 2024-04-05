<?php

namespace App\Rules;

use App\Common\Enums\Action;
use Illuminate\Contracts\Validation\Rule;

class CheckValidClaimValueRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $attribute === 'claim_value' &&
            in_array($value, array_values(Action::toArray()));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute is invalid.';
    }
}
