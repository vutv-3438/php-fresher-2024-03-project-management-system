<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Http\StatusCode;
use App\Common\Enums\Resource;
use App\Models\Role;
use App\Models\RoleClaim;
use App\Models\User;
use App\Services\Repositories\Contracts\IRoleRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RoleClaimPolicy
{
    use HandlesAuthorization;

    private IRoleRepository $roleRepository;

    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function before(User $user, string $ability, $roleClaim): bool
    {
        $projectId = getRouteParam('projectId');
        $roleId = getRouteParam('roleId') ?? getRouteParam('role')->id;

        if ($roleClaim instanceof RoleClaim && $roleClaim->role->id !== +$roleId) {
            abort(StatusCode::NOT_FOUND);
        }

        return $this->roleRepository->checkInProject($roleId, $projectId);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        $projectId = getRouteParam('projectId');
        $role = getRouteParam('role');

        return $this->roleRepository->checkRoleInProject($role->id, $projectId) &&
            $user->hasPermissionInProject(
                getRouteParam('projectId'),
                Resource::ROLE_CLAIM,
                Action::VIEW_ANY
            );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param RoleClaim $roleClaim
     * @return bool
     */
    public function view(User $user, RoleClaim $roleClaim): bool
    {
        $projectId = getRouteParam('projectId');

        return $roleClaim->role->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE_CLAIM,
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
        $projectId = getRouteParam('projectId');
        $roleId = getRouteParam('roleId') ?? getRouteParam('role')->id;

        return $this->roleRepository->checkRoleInProject($roleId, $projectId) &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE_CLAIM,
                Action::CREATE
            );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param RoleClaim $roleClaim
     * @return bool
     */
    public function update(User $user, RoleClaim $roleClaim): bool
    {
        $projectId = getRouteParam('projectId');

        return $roleClaim->role->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE_CLAIM,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param RoleClaim $roleClaim
     * @return bool
     */
    public function delete(User $user, RoleClaim $roleClaim): bool
    {
        $projectId = getRouteParam('projectId');

        return $roleClaim->role->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ROLE_CLAIM,
                Action::DELETE
            );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param RoleClaim $roleClaim
     * @return Response|bool
     */
    public function restore(User $user, RoleClaim $roleClaim)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param RoleClaim $roleClaim
     * @return Response|bool
     */
    public function forceDelete(User $user, RoleClaim $roleClaim)
    {
        //
    }
}
