<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckObjectInCurrentProject implements Rule
{
    protected string $objectType;

    public function __construct($objectType)
    {
        $this->objectType = $objectType;
    }

    public function passes($attribute, $value): bool
    {
        $projectId = request()->input('projectId');

        return DB::table($this->objectType)
            ->where('id', $value)
            ->where('project_id', $projectId)
            ->exists();
    }

    public function message(): string
    {
        return 'The selected ' . $this->objectType . ' does not exist in the current project.';
    }
}
