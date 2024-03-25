<?php

namespace App\Services\Repositories;

use App\Models\UserRole;

class UserRoleRepository extends BaseRepository
{
    public function __construct(UserRole $userRole)
    {
        parent::__construct($userRole);
    }
}
