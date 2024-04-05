<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckDuplicateInProject implements Rule
{
    protected $model;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !$this->model::where('project_id', request()->input('projectId'))
            ->where($attribute, $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The :attribute has been existed!');
    }
}
