<?php

namespace Tests\Unit\Models;

use App\Models\Issue;
use App\Models\WorkFlow;
use App\Models\WorkFlowStep;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkFlowStepTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new WorkFlowStep(), [], [], []);
    }

    public function test_work_flow_relation()
    {
        $m = new WorkFlowStep();
        $r = $m->workFlow();

        $this->assertBelongsToRelation($r, $m, new WorkFlow(), 'work_flow_id');
    }

    public function test_issues_relation()
    {
        $m = new WorkFlowStep();
        $r = $m->issues();

        $this->assertHasRelation($r, $m,'status_id');
    }

    public function test_previous_statuses_relation()
    {
        $m = new WorkFlowStep();
        $r = $m->previousStatuses();

        $this->assertBelongsToManyRelation($r, $m, 'next_steps_allowed', 'to_status_id', 'from_status_id');
    }

    public function test_next_statuses_allowed_relation()
    {
        $m = new WorkFlowStep();
        $r = $m->nextStatusesAllowed();

        $this->assertBelongsToManyRelation($r, $m, 'next_steps_allowed', 'from_status_id', 'to_status_id');
    }
}
