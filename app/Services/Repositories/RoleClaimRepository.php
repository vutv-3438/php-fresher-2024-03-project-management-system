<?php

namespace App\Services\Repositories;

use App\Models\RoleClaim;
use App\Services\Repositories\Contracts\IRoleClaimRepository;

class RoleClaimRepository extends BaseRepository implements IRoleClaimRepository
{
    public function __construct(RoleClaim $claim)
    {
        parent::__construct($claim);
    }

    public function create(array $attributes): RoleClaim
    {
        return parent::create([
            'claim_type' => $attributes['claim_type'],
            'claim_value' => $attributes['claim_value'],
            'role_id' => $attributes['role_id'],
        ]);
    }

    public function update(array $attributes, int $id): bool
    {
        return parent::update([
            'claim_type' => $attributes['claim_type'],
            'claim_value' => $attributes['claim_value'],
        ], $id);
    }
}
