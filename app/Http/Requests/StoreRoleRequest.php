<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Rules\CheckDuplicateInProject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

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
