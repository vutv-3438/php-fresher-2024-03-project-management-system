<?php

namespace App\Services\Repositories\Contracts;

use App\Models\WorkFlow;
use Illuminate\Database\Eloquent\Collection;

interface IWorkFlowRepository extends IBaseRepository
{
    public function create(array $attributes): WorkFlow;

    public function getWorkFlowByProjectId(int $projectId): Collection;
}
