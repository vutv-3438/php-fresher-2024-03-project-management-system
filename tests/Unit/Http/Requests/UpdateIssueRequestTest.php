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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class UpdateIssueRequestTest extends TestCase
{
    use RefreshDatabase;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
    }

    public function test_it_contains_valid_rules()
    {
        $r = new UpdateIssueRequest();

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
                function ($attribute, $value, $fail) {
                    if ($value === getRouteParam('issue')) {
                        $fail($attribute . ' must be different with current id');
                    }
                },
                function ($attribute, $value, $fail) {
                    $childIssues = Issue::find(getRouteParam('issue'))
                        ->childIssues
                        ->pluck('id')
                        ->toArray();
                    if (in_array($value, $childIssues)) {
                        $fail($attribute . ' must be different with child issues id');
                    }
                },
            ],
            'start_date' => ['nullable', 'date'],
            'due_date' => [
                'nullable',
                'date',
                new StartDateGreaterThanEnddate(request()->get('start_date')),
            ],
            'estimated_time' => ['nullable', 'numeric', 'min:0', 'max:8'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'projectId' => ['required', 'integer', Rule::exists('projects', 'id')],
        ], $r->rules());
    }

    public function test_update_issue_request_validation_passes()
    {
        $project = Project::factory()->create();
        $issueType = IssueType::factory()->withProject($project->id)->create();
        $workFlow = WorkFlow::factory()->withProject($project->id)->create();
        $workFlowStep = WorkFlowStep::factory()->withWorkFlow($workFlow->id)->create();
        $issue = Issue::factory()->withProject($project->id)->create();
        $parentIssue = Issue::factory()->withProject($project->id)->create();
        $user = User::factory()->create();

        $url = route('issues.update', ['projectId' => $project->id, 'issue' => $issue->id]);
        $request = new UpdateIssueRequest();
        $data = [
            'title' => 'Sample Issue',
            'issue_type_id' => $issueType->id,
            'status_id' => $workFlowStep->id,
            'priority' => Priority::HIGH,
            'start_date' => '2024-04-15',
            'due_date' => '2024-04-20',
            'projectId' => $project->id,
            'parent_issue_id' => $parentIssue->id,
        ];
        $request->merge($data);
        $this->actingAs($user)
            ->put($url, ['projectId' => $project->id, 'issue' => $issue->id]);

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_update_issue_request_validation_with_boundary()
    {
        $project = Project::factory()->create();
        $issueType = IssueType::factory()->withProject($project->id)->create();
        $workFlow = WorkFlow::factory()->withProject($project->id)->create();
        $workFlowStep = WorkFlowStep::factory()->withWorkFlow($workFlow->id)->create();
        $issue = Issue::factory()->withProject($project->id)->create();
        Issue::factory()->withProject($project->id)->create();
        $user = User::factory()->create();
        $url = route('issues.update', ['projectId' => $project->id, 'issue' => $issue->id]);

        $request = new UpdateIssueRequest();
        $data = [
            'title' => Str::random(255),
            'issue_type_id' => $issueType->id,
            'status_id' => $workFlowStep->id,
            'priority' => Arr::last(Priority::toArray()),
            'projectId' => $project->id,
            'parent_issue_id' => $issue->id,
            'start_date' => '2024-04-15',
            'due_date' => '2024-04-15',
            'estimated_time' => '8',
            'progress' => '100',
        ];
        $request->merge($data);
        // Don't need to register request to app instance
        $this->actingAs($user)
            ->put($url, ['projectId' => $project->id, 'issue' => $issue->id]);

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider dataThatShouldFail
     */
    public function test_validation_will_fail(array $requestData): void
    {
        $request = new StoreIssueRequest();
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $issue = Issue::factory()->withProject($project->id)->create();
        $url = route('issues.update', ['projectId' => $project->id, 'issue' => $issue->id]);

        $request->merge($requestData);
        $this->actingAs($user)
            ->put($url, ['projectId' => $project->id, 'issue' => $issue->id]);
        $validator = Validator::make($requestData, $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function dataThatShouldFail(): array
    {
        $project = Project::factory()->create();
        $project2 = Project::factory()->create();
        $issueType = IssueType::factory()->withProject($project->id)->create();
        $issueType2 = IssueType::factory()->withProject($project2->id)->create();
        $workFlow = WorkFlow::factory()->withProject($project->id)->create();
        $workFlow2 = WorkFlow::factory()->withProject($project2->id)->create();
        $workFlowStep = WorkFlowStep::factory()->withWorkFlow($workFlow->id)->create();
        $workFlowStep2 = WorkFlowStep::factory()->withWorkFlow($workFlow2->id)->create();
        $issue = Issue::factory()->withProject($project->id)->create();
        $childIssue = Issue::factory()
            ->withProject($project->id)
            ->withParent($issue->id)
            ->create();
        $issue2 = Issue::factory()->withProject($project2->id)->create();
        $remainValidData = [
            'title' => 'Title',
            'issue_type_id' => $issueType->id,
            'status_id' => $workFlowStep->id,
            'priority' => Priority::HIGH,
            'projectId' => $project->id,
        ];

        return [
            // Title
            'no_title' => [
                array_merge($remainValidData, ['title' => null]),
            ],
            'differ_string_type_title' => [
                array_merge($remainValidData, ['title' => 1]),
            ],
            'more_than_255_title' => [
                array_merge($remainValidData, ['title' => Str::random(256)]),
            ],
            // Issue type
            'no_issue_type_id' => [
                array_merge($remainValidData, ['issue_type_id' => null]),
            ],
            'differ_int_type_issue_type_id' => [
                array_merge($remainValidData, ['issue_type_id' => '1']),
            ],
            'not_exist_issue_type_id' => [
                array_merge($remainValidData, ['issue_type_id' => 100]),
            ],
            'not_in_project_issue_type_id' => [
                array_merge($remainValidData, ['issue_type_id' => $issueType2->id]),
            ],
            // Status
            'no_status_id' => [
                array_merge($remainValidData, ['status_id' => null]),
            ],
            'differ_int_type_status_id' => [
                array_merge($remainValidData, ['status_id' => 'invalid_status_id']),
            ],
            'not_exist_status_id' => [
                array_merge($remainValidData, ['status_id' => 100]),
            ],
            'not_in_project_status_id' => [
                array_merge($remainValidData, ['status_id' => $workFlowStep2->id]),
            ],
            // Priority
            'no_priority' => [
                array_merge($remainValidData, ['priority' => null]),
            ],
            'differ_string_type_priority' => [
                array_merge($remainValidData, ['priority' => 1]),
            ],
            'more_than_255_char_priority' => [
                array_merge($remainValidData, ['priority' => Str::random(256)]),
            ],
            'not_in_approved_array_priority' => [
                array_merge($remainValidData, ['priority' => 'HIGHER']),
            ],
            // Parent issue
            'differ_int_type_parent_issue_id' => [
                array_merge($remainValidData, ['parent_issue_id' => '1']),
            ],
            'not_exist_parent_issue_id' => [
                array_merge($remainValidData, ['parent_issue_id' => 100]),
            ],
            'not_in_project_parent_issue_id' => [
                array_merge($remainValidData, ['parent_issue_id' => $issue2->id]),
            ],
            'different_current_id_parent_issue_id' => [
                array_merge($remainValidData, ['parent_issue_id' => $issue->id]),
            ],
            'different_child_issue_ids_parent_issue_id' => [
                array_merge($remainValidData, ['parent_issue_id' => $childIssue->id]),
            ],
            // Start date
            'differ_date_type_start_date' => [
                array_merge($remainValidData, ['start_date' => 'invalid_date']),
            ],
            // Due date
            'differ_date_type_due_date' => [
                array_merge($remainValidData, ['due_date' => 'invalid_date']),
            ],
            'due_date_less_than_start_date' => [
                array_merge($remainValidData, [
                    'start_date' => '2024-04-15',
                    'due_date' => '2024-04-14',
                ]),
            ],
            // Estimated time
            'differ_numeric_type_estimated_time' => [
                array_merge($remainValidData, ['estimated_time' => 'invalid_type']),
            ],
            'less_than_min_estimated_time' => [
                array_merge($remainValidData, ['estimated_time' => -1]),
            ],
            'more_than_max_estimated_time' => [
                array_merge($remainValidData, ['estimated_time' => 9]),
            ],
            // Progress
            'differ_numeric_type_progress' => [
                array_merge($remainValidData, ['progress' => 'invalid_type']),
            ],
            'less_than_min_progress' => [
                array_merge($remainValidData, ['progress' => -1]),
            ],
            'more_than_max_progress' => [
                array_merge($remainValidData, ['progress' => 101]),
            ],
            // Project id
            'no_projectId' => [
                array_merge($remainValidData, ['priority' => null]),
            ],
            'differ_integer_type_projectId' => [
                array_merge($remainValidData, ['projectId' => 'invalid_type']),
            ],
            'not_exist_projectId' => [
                array_merge($remainValidData, ['projectId' => 100]),
            ],
        ];
    }
}
