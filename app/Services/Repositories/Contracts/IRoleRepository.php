<?php

namespace App\Services\Repositories\Contracts;

use App\Models\Role;

interface IRoleRepository extends IBaseRepository
{
    public function createManagerRoleInProject(int $projectId): Role;
}
