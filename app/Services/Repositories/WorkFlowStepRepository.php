<?php

namespace App\Services\Repositories;

use App\Models\WorkFlowStep;

class WorkFlowStepRepository extends BaseRepository
{
    public function __construct(WorkFlowStep $workFlowStep)
    {
        parent::__construct($workFlowStep);
    }
}
