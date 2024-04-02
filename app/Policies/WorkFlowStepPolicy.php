<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\User;
use App\Models\WorkFlowStep;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WorkFlowStepPolicy
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
            Resource::WORK_FLOW_STEP,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param WorkFlowStep $workFlowStep
     * @return bool
     */
    public function view(User $user, WorkFlowStep $workFlowStep): bool
    {
        $projectId = getRouteParam('projectId');

        return $workFlowStep->workFlow->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::WORK_FLOW_STEP,
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
            Resource::WORK_FLOW_STEP,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param WorkFlowStep $workFlowStep
     * @return bool
     */
    public function update(User $user, WorkFlowStep $workFlowStep): bool
    {
        $projectId = getRouteParam('projectId');

        return $workFlowStep->workFlow()->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::WORK_FLOW_STEP,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param WorkFlowStep $workFlowStep
     * @return bool
     */
    public function delete(User $user, WorkFlowStep $workFlowStep): bool
    {
        $projectId = getRouteParam('projectId');

        return $workFlowStep->workFlow()->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::WORK_FLOW_STEP,
                Action::DELETE
            );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param WorkFlowStep $workFlowStep
     * @return Response|bool
     */
    public function restore(User $user, WorkFlowStep $workFlowStep)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param WorkFlowStep $workFlowStep
     * @return Response|bool
     */
    public function forceDelete(User $user, WorkFlowStep $workFlowStep)
    {
        //
    }
}
