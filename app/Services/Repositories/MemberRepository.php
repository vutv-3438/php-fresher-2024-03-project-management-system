<?php

namespace App\Services\Repositories;

use App\Common\Enums\Role as RoleEnum;
use App\Models\Member;
use App\Models\Role;
use App\Models\UserRole;
use App\Services\Repositories\Contracts\IMemberRepository;

class MemberRepository extends UserRepository implements IMemberRepository
{
    public function __construct(Member $member)
    {
        parent::__construct($member);
    }

    public function update(array $attributes, int $id): bool
    {
        if (!isset($attributes['role_id'])) {
            return false;
        }

        $currentMember = $this->model->findOrFail($id);
        $currentMember->roles()->sync([$attributes['role_id']]);
        return true;
    }

    public function isLastManagerInProject(int $projectId): bool
    {
        $countManagerInProject = $this->model
            ->whereHas('roles', function ($query) use ($projectId) {
                $query->where('project_id', $projectId)
                    ->where('name', RoleEnum::MANAGER);
            })
            ->count();

        return $countManagerInProject === 1;
    }

    public function getEmailByUserName(string $userName)
    {
        $user = $this->model->where('user_name', $userName)->first();
        return $user->email ?? null;
    }

    public function getByEmails(array $emails)
    {
        $models = $this->model->whereIn('email', $emails)->get();
        $result = $models->pluck(null, 'email')->all();

        return $result;
    }

    public function addDefaultRoleToUser(int $userId, int $projectId)
    {
        $defaultRole = Role::where('project_id', $projectId)
            ->where('is_default', true)
            ->first();
        if(!isset($defaultRole))
        {
            $defaultRole = Role::where('project_id', $projectId)->first();
        }

        $this->model->findOrFail($userId)->roles()->attach($defaultRole->id);
    }

    public function deleteMemberInProject(Member $member, int $roleId)
    {
        $role = Role::find($roleId);
        $member->roles()->detach($role->id);
    }
}
