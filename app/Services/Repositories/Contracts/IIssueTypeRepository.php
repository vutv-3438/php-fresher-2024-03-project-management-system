<?php

namespace App\Services\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface IIssueTypeRepository extends IBaseRepository
{
    public function getIssueTypesByProjectId(int $projectId): Collection;
}
