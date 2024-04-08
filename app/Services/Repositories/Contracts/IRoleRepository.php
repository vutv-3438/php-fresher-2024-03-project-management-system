<?php

namespace App\Services\Repositories\Contracts;

use App\Models\Role;

interface IRoleRepository extends IBaseRepository
{
    public function createManagerRoleInProject(int $projectId): Role;

    public function create(array $attributes): Role;

    public function checkRoleInProject(int $roleId, $projectId): bool;

    public function markAsDefaultRoleInTheProject(int $projectId, int $roleId);
}
