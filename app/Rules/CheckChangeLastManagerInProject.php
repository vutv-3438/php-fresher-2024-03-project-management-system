<?php

namespace App\Rules;

use App\Common\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Contracts\Validation\Rule;

class CheckChangeLastManagerInProject implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $projectId = getRouteParam('projectId');
        $member = getRouteParam('member');
        $isLastManagerRoleInProject = UserRole::countManagerRoleInProject(+$projectId) === 1;
        $currentRole = Role::where('project_id', $projectId)
            ->where('name', RoleEnum::MANAGER)
            ->whereHas('users', function ($query) use ($member) {
                $query->where('id', $member->id);
            })
            ->first();
        $isChangeManagerRole = isset($currentRole) && +$value !== $currentRole->id;

        return !$isLastManagerRoleInProject || !$isChangeManagerRole;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The project must be have at least manger role.');
    }
}
