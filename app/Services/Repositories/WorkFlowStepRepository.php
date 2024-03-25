<?php

namespace App\Services\Repositories;

use App\Models\WorkFlowStep;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use Illuminate\Database\Eloquent\Model;

class WorkFlowStepRepository extends BaseRepository implements IWorkFlowStepRepository
{
    private const DEFAULT_ORDER = 1;

    public function __construct(WorkFlowStep $workFlowStep)
    {
        parent::__construct($workFlowStep);
    }

    public function create(array $attributes): Model
    {
        return parent::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'order' => $attributes['order'] ?? self::DEFAULT_ORDER,
            'work_flow_id' => $attributes['work_flow_id'],
        ]);
    }
}
