<?php

namespace Http\Requests;

use App\Common\Enums\Priority;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\IssueType;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkFlow;
use App\Models\WorkFlowStep;
use App\Rules\CheckObjectInCurrentProject;
use App\Rules\CheckRelationInCurrentProject;
use App\Rules\StartDateGreaterThanEnddate;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery;
use Tests\TestCase;

class StoreIssueRequestTest extends TestCase
{
    public function test_it_contains_valid_rules()
    {
        $r = new StoreIssueRequest();

        $this->assertEquals([
            'title' => ['required', 'string', 'max:255'],
            'issue_type_id' => [
                'required',
                'integer',
                Rule::exists('issue_types', 'id'),
                new CheckObjectInCurrentProject('issue_types'),
            ],
            'status_id' => [
                'required',
                'integer',
                Rule::exists('work_flow_steps', 'id'),
                new CheckRelationInCurrentProject(WorkFlowStep::class, 'workFlow'),
            ],
            'priority' => ['required', 'string', 'max:255', Rule::in(Priority::toArray())],
            'parent_issue_id' => [
                'nullable',
                'integer',
                Rule::exists('issues', 'id'),
                new CheckObjectInCurrentProject('issues'),
            ],
            'start_date' => ['nullable', 'date'],
            'due_date' => [
                'nullable',
                'date',
                new StartDateGreaterThanEnddate(request()->get('start_date')),
            ],
            'estimated_time' => ['nullable', 'numeric', 'min:0', 'max:8'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'projectId' => ['required', 'int', Rule::exists('projects', 'id')],
        ], $r->rules());
    }

    public function test_store_issue_request_validation_passes()
    {
        $project = Project::factory()->create();
        $issueType = IssueType::factory()->withProject($project->id)->create();
        $workFlow = WorkFlow::factory()->withProject($project->id)->create();
        $workFlowStep = WorkFlowStep::factory()->withWorkFlow($workFlow->id)->create();
        $issue = Issue::factory()->withProject($project->id)->create();
        $request = new StoreIssueRequest();
        $data = [
            'title' => 'Sample Issue',
            'issue_type_id' => $issueType->id,
            'status_id' => $workFlowStep->id,
            'priority' => Priority::HIGH,
            'start_date' => '2024-04-15',
            'due_date' => '2024-04-20',
            'projectId' => $project->id,
            'parent_issue_id' => $issue->id,
        ];
        $request->merge($data);
        $this->app->instance('request', $request);

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }
}
