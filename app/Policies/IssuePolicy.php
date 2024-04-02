<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IssuePolicy
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
            Resource::ISSUE,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function view(User $user, Issue $issue): bool
    {
        $projectId = getRouteParam('projectId');

        return $issue->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ISSUE,
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
            Resource::ISSUE,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function update(User $user, Issue $issue): bool
    {
        $projectId = getRouteParam('projectId');

        return $issue->project_id === $projectId &&
            $user->hasPermissionInProject($projectId, Resource::ISSUE, Action::UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function delete(User $user, Issue $issue): bool
    {
        $projectId = getRouteParam('projectId');

        return $issue->project_id === $projectId &&
            $user->hasPermissionInProject($projectId, Resource::ISSUE, Action::DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return Response|bool
     */
    public function restore(User $user, Issue $issue)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return Response|bool
     */
    public function forceDelete(User $user, Issue $issue)
    {
        //
    }
}
