<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'names_or_emails' => ['required', 'string', 'max:255'],
        ];
    }
}
