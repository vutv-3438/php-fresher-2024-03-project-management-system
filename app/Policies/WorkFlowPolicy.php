<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\User;
use App\Models\WorkFlow;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WorkFlowPolicy
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
            Resource::WORK_FLOW,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param WorkFlow $workFlow
     * @return bool
     */
    public function view(User $user, WorkFlow $workFlow): bool
    {
        $projectId = getRouteParam('projectId');

        return $workFlow->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::WORK_FLOW,
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
            Resource::WORK_FLOW,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param WorkFlow $workFlow
     * @return bool
     */
    public function update(User $user, WorkFlow $workFlow): bool
    {
        $projectId = getRouteParam('projectId');

        return $workFlow->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::WORK_FLOW,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param WorkFlow $workFlow
     * @return bool
     */
    public function delete(User $user, WorkFlow $workFlow)
    {
        $projectId = getRouteParam('projectId');

        return $workFlow->project_id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::WORK_FLOW,
                Action::DELETE
            );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param WorkFlow $workFlow
     * @return Response|bool
     */
    public function restore(User $user, WorkFlow $workFlow)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param WorkFlow $workFlow
     * @return Response|bool
     */
    public function forceDelete(User $user, WorkFlow $workFlow)
    {
        //
    }
}
