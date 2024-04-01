<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\LogTime;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LogTimePolicy
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
            Resource::LOG_TIME,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param LogTime $logTime
     * @return bool
     */
    public function view(User $user, LogTime $logTime): bool
    {
        return $logTime->user_id === $user->id &&
            $user->hasPermissionInProject(
                getRouteParam('projectId'),
                Resource::LOG_TIME,
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
            Resource::LOG_TIME,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param LogTime $logTime
     * @return bool
     */
    public function update(User $user, LogTime $logTime): bool
    {
        return $logTime->user_id === $user->id &&
            $user->hasPermissionInProject(
                getRouteParam('projectId'),
                Resource::LOG_TIME,
                Action::UPDATE
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param LogTime $logTime
     * @return bool
     */
    public function delete(User $user, LogTime $logTime): bool
    {
        return $logTime->user_id === $user->id &&
            $user->hasPermissionInProject(
                getRouteParam('projectId'),
                Resource::LOG_TIME,
                Action::DELETE
            );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param LogTime $logTime
     * @return Response|bool
     */
    public function restore(User $user, LogTime $logTime)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param LogTime $logTime
     * @return Response|bool
     */
    public function forceDelete(User $user, LogTime $logTime)
    {
        //
    }
}
