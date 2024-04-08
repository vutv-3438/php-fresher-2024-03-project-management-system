<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Rules\CheckDuplicateInProject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new CheckDuplicateInProject(Role::class)],
            'projectId' => ['required', 'int', Rule::exists('projects', 'id')],
        ];
    }
}
