<?php

namespace App\Http\Requests;

use App\Common\Enums\Priority;
use App\Models\Issue;
use App\Models\WorkFlowStep;
use App\Rules\CheckObjectInCurrentProject;
use App\Rules\CheckRelationInCurrentProject;
use App\Rules\StartDateGreaterThanEnddate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIssueRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
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
                new StartDateGreaterThanEnddate($this->request->get('start_date')),
            ],
            'estimated_time' => ['nullable', 'numeric', 'min:0', 'max:8'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'projectId' => ['required', 'int', Rule::exists('projects', 'id')],
        ];
    }
}
