<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\IssueType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IssueTypePolicy
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
            Resource::ISSUE_TYPE,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param IssueType $issueType
     * @return bool
     */
    public function view(User $user, IssueType $issueType): bool
    {
        $projectId = getRouteParam('projectId');

        return $issueType->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ISSUE_TYPE,
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
            Resource::ISSUE_TYPE,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param IssueType $issueType
     * @return bool
     */
    public function update(User $user, IssueType $issueType): bool
    {
        $projectId = getRouteParam('projectId');

        return $issueType->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ISSUE_TYPE,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param IssueType $issueType
     * @return bool
     */
    public function delete(User $user, IssueType $issueType): bool
    {
        $projectId = getRouteParam('projectId');

        return $issueType->project_id === $projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::ISSUE_TYPE,
                Action::DELETE
            );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param IssueType $issueType
     * @return Response|bool
     */
    public function restore(User $user, IssueType $issueType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param IssueType $issueType
     * @return Response|bool
     */
    public function forceDelete(User $user, IssueType $issueType)
    {
        //
    }
}
