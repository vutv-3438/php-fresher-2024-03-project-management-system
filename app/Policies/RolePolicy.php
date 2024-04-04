<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionInProject(
            getRouteParam('projectId'),
            Resource::ROLE,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function view(User $user, Role $role): bool
    {
        $projectId = getRouteParam('projectId');

        return $role->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE,
                Action::VIEW
            );
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionInProject(
            getRouteParam('projectId'),
            Resource::ROLE,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function update(User $user, Role $role): bool
    {
        $projectId = getRouteParam('projectId');

        return $role->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function delete(User $user, Role $role): bool
    {
        $projectId = getRouteParam('projectId');

        return $role->project_id === +$projectId &&
            !$role->isManager() &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE,
                Action::DELETE
            );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
