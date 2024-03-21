<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateGreaterThanCurrent implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strtotime($value) >= strtotime('today');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute must be greater equal than current date');
    }
}
