<?php

namespace Tests\Unit\Models;

use App\Models\IssueType;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueTypeTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new IssueType(), [], [], []);
    }

    public function test_project_relation()
    {
        $m = new IssueType();
        $r = $m->project();

        $this->assertBelongsToRelation($r, $m, new Project(), 'project_id');
    }

    public function test_issues_relation()
    {
        $m = new IssueType();
        $r = $m->issues();

        $this->assertHasRelation($r, $m, 'issue_type_id');
    }
}
