<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\WorkFlow;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkFlowTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new WorkFlow(), [], [], []);
    }

    public function test_project_relation()
    {
        $m = new WorkFlow();
        $r = $m->project();

        $this->assertBelongsToRelation($r, $m, new Project(), 'project_id');
    }

    public function test_work_flow_steps_relation()
    {
        $m = new WorkFlow();
        $r = $m->workFlowSteps();

        $this->assertHasRelation($r, $m,'work_flow_id');
    }
}
