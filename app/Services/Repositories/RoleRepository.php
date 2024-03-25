<?php

namespace App\Services\Repositories;

use App\Common\Enums\Role as RolesEnum;
use App\Models\Role;
use App\Services\Repositories\Contracts\IRoleRepository;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function createManagerRoleInProject(int $projectId): Role
    {
        $role = $this->model->create([
            'name' => RolesEnum::MANAGER,
            'description' => 'Manager role',
            'project_id' => $projectId,
        ]);
        auth()->user()->roles()->attach($role->id);

        return $role;
    }
}
