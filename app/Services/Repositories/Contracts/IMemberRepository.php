<?php

namespace App\Services\Repositories\Contracts;

use App\Models\Member;

interface IMemberRepository extends IUserRepository
{
    public function isLastManagerInProject(int $projectId): bool;

    public function getEmailByUserName(string $userName);

    public function getByEmails(array $emails);

    public function addDefaultRoleToUser(int $userId, int $projectId);

    public function deleteMemberInProject(Member $member, int $roleId);
}
