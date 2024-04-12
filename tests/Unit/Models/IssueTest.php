<?php

namespace Tests\Unit\Models;

use App\Models\Issue;
use App\Models\IssueType;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkFlowStep;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Issue(), [], [], []);
    }

    public function test_project_relation()
    {
        $m = new Issue();
        $r = $m->project();

        $this->assertBelongsToRelation($r, $m, new Project(), 'project_id');
    }

    public function test_status_relation()
    {
        $m = new Issue();
        $r = $m->status();

        $this->assertBelongsToRelation($r, $m, new WorkFlowStep(), 'status_id');
    }

    public function test_issue_type_relation()
    {
        $m = new Issue();
        $r = $m->issueType();

        $this->assertBelongsToRelation($r, $m, new IssueType(), 'issue_type_id');
    }

    public function test_parent_issue_relation()
    {
        $m = new Issue();
        $r = $m->parentIssue();

        $this->assertBelongsToRelation($r, $m, new Issue(), 'parent_issue_id');
    }

    public function test_assignee_relation()
    {
        $m = new Issue();
        $r = $m->assignee();

        $this->assertBelongsToRelation($r, $m, new User(), 'assignee_id');
    }

    public function test_reporter_relation()
    {
        $m = new Issue();
        $r = $m->reporter();

        $this->assertBelongsToRelation($r, $m, new User(), 'reporter_id');
    }

    public function test_child_issues_relation()
    {
        $m = new Issue();
        $r = $m->childIssues();

        $this->assertHasRelation($r, $m, 'parent_issue_id');
    }

    public function test_log_times_relation()
    {
        $m = new Issue();
        $r = $m->logTimes();

        $this->assertHasRelation($r, $m, 'issue_id');
    }

    public function test_due_date_accessor()
    {
        $user = new Issue();
        $dueDate = now();
        $user->setRawAttributes([
            'due_date' => $dueDate,
        ]);
        $this->assertEquals(Carbon::parse($dueDate)->format('d-m-Y'), $user->due_date);

        $user->setRawAttributes([
            'due_date' => null,
        ]);
        $this->assertEquals('---', $user->due_date);
    }
}
