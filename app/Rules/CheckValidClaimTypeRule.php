<?php

namespace App\Rules;

use App\Common\Enums\Resource;
use Illuminate\Contracts\Validation\Rule;

class CheckValidClaimTypeRule implements Rule
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
        return $attribute === 'claim_type' &&
            in_array($value, array_values(Resource::toArray()));
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
