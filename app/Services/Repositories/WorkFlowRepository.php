<?php

namespace App\Services\Repositories;

use App\Models\WorkFlow;
use App\Services\Repositories\Contracts\IWorkFlowRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkFlowRepository extends BaseRepository implements IWorkFlowRepository
{
    public function __construct(WorkFlow $project)
    {
        parent::__construct($project);
    }

    public function create(array $attributes): WorkFlow
    {
        return parent::create([
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'project_id' => $attributes['projectId'],
        ]);
    }

    public function getWorkFlowByProjectId(int $projectId, int $paginatePerPage = 10): LengthAwarePaginator
    {
        return $this->model->where('project_id', $projectId)->paginate($paginatePerPage);
    }
}
