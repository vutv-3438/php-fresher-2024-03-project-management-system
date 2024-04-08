<?php

namespace App\Services\Repositories;

use App\Models\WorkFlow;
use App\Models\WorkFlowStep;
use App\Services\Repositories\Contracts\IWorkFlowRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function update(array $attributes, int $id): bool
    {
        DB::transaction(function () use ($attributes, $id) {
            parent::update([
                'title' => $attributes['title'],
                'description' => $attributes['description'],
            ], $id);

            foreach (array_keys($attributes['next_steps']) as $currentStep) {
                $step = WorkFlowStep::find($currentStep);
                $step->nextStatusesAllowed()->sync($attributes['next_steps'][$currentStep]);
            }
        });

        return true;
    }

    public function getWorkFlowByProjectId(int $projectId): Collection
    {
        return $this->model->where('project_id', $projectId)->get();
    }
}
