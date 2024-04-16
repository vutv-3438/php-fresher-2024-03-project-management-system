<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(
            new Project(),
            [],
            [],
            [],
            [],
            [
                'start_date' => 'string',
                'end_date' => 'string',
                'id' => 'int',
            ]
        );
    }

    public function test_issues_relation()
    {
        $m = new Project();
        $r = $m->issues();

        $this->assertHasRelation($r, $m, 'project_id');
    }

    public function test_work_flows_relation()
    {
        $m = new Project();
        $r = $m->workFlows();

        $this->assertHasRelation($r, $m, 'project_id');
    }

    public function test_issue_types_relation()
    {
        $m = new Project();
        $r = $m->issueTypes();

        $this->assertHasRelation($r, $m, 'project_id');
    }

    public function test_roles_relation()
    {
        $m = new Project();
        $r = $m->roles();

        $this->assertHasRelation($r, $m, 'project_id');
    }
}
