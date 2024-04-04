<?php

namespace App\Services\Repositories\Contracts;

use App\Models\RoleClaim;

interface IRoleClaimRepository extends IBaseRepository
{
    public function create(array $attributes): RoleClaim;
}
