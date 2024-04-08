<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Project $project): bool
    {
        $projectId = getRouteParam('id');

        return $project->id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::PROJECT,
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function update(User $user, Project $project): bool
    {
        $projectId = getRouteParam('id');

        return $project->id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::PROJECT,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Project $project): bool
    {
        $projectId = getRouteParam('id');

        return $project->id === +$projectId &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::PROJECT,
                Action::DELETE
            );
    }
}
