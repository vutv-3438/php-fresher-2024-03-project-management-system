<?php

namespace App\Http\Requests;

use App\Rules\CheckDeleteLastManagerInProject;
use Illuminate\Foundation\Http\FormRequest;

class DeleteMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'integer', new CheckDeleteLastManagerInProject()],
        ];
    }
}
