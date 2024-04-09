<?php

namespace App\Http\Requests;

use App\Rules\CheckChangeLastManagerInProject;
use App\Rules\CheckObjectInCurrentProject;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role_id' => [
                'required',
                'integer',
                new CheckObjectInCurrentProject('roles'),
                new CheckChangeLastManagerInProject(),
            ],
        ];
    }
}
