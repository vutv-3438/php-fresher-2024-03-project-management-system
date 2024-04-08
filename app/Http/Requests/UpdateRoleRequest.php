<?php

namespace App\Http\Requests;

use App\Rules\CheckChangeManagerRoleName;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new CheckChangeManagerRoleName()],
        ];
    }
}
