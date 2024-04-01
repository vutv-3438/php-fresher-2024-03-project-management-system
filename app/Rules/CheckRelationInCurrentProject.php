<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckRelationInCurrentProject implements Rule
{
    protected $model;
    protected $relationship;

    public function __construct($model, $relationship)
    {
        $this->model = $model;
        $this->relationship = $relationship;
    }

    public function passes($attribute, $value): bool
    {
        $projectId = request()->input('projectId');

        return $this->model::whereHas($this->relationship, function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->exists();
    }

    public function message(): string
    {
        return 'The selected object does not exist in the current project.';
    }
}
