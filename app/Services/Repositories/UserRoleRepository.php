<?php

namespace App\Services\Repositories;

use App\Models\UserRole;

class UserRoleRepository extends BaseRepository
{
    public function __construct(UserRole $project)
    {
        parent::__construct($project);
    }
}
