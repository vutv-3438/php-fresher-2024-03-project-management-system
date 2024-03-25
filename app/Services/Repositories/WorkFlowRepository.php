<?php

namespace App\Services\Repositories;

use App\Models\WorkFlow;
use App\Services\Repositories\Contracts\IWorkFlowRepository;
use Illuminate\Database\Eloquent\Collection;

class WorkFlowRepository extends BaseRepository implements IWorkFlowRepository
{
    public function __construct(WorkFlow $workFlow)
    {
        parent::__construct($workFlow);
    }

    public function create(array $attributes): WorkFlow
    {
        return parent::create([
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'project_id' => $attributes['projectId'],
        ]);
    }

    public function getWorkFlowByProjectId(int $projectId): Collection
    {
        return $this->model->where('project_id', $projectId)->get();
    }
}
