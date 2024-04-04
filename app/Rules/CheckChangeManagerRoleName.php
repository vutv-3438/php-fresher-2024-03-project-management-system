<?php

namespace App\Rules;

use App\Common\Enums\Role as RoleEnum;
use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;

class CheckChangeManagerRoleName implements Rule
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
        $isChangeManagerRole = Role::where('id', getRouteParam('role'))
            ->where('name', RoleEnum::MANAGER)
            ->exists();
        $isChangeManagerName = $attribute === 'name' && $value !== RoleEnum::MANAGER;

        return !$isChangeManagerRole || !$isChangeManagerName;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The manager role name can not change!';
    }
}
