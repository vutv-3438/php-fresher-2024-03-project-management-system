<?php

namespace App\Policies;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Models\Member;
use App\Models\User;
use App\Services\Repositories\Contracts\IMemberRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    use HandlesAuthorization;

    private IMemberRepository $memberRepository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(IMemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

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
            Resource::MEMBER,
            Action::VIEW_ANY
        );
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        $projectId = getRouteParam('projectId');

        return $user->hasPermissionInProject(
            $projectId,
            Resource::MEMBER,
            Action::CREATE
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Member $member
     * @return bool
     */
    public function update(User $user, Member $member): bool
    {
        $projectId = getRouteParam('projectId');

        return $user->hasPermissionInProject(
            $projectId,
            Resource::MEMBER,
            Action::UPDATE
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Member $member
     * @return bool
     */
    public function delete(User $user, Member $member): bool
    {
        $projectId = getRouteParam('projectId');
        $isMemberExistInTheProject = $member
            ->roles()
            ->where('project_id', $projectId)
            ->exists();

        return $isMemberExistInTheProject &&
            $user->hasPermissionInProject(
                $projectId,
                Resource::MEMBER,
                Action::DELETE
            );
    }
}
