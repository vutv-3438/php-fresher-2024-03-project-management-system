<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->request->get('id')),
            ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^[0-9]{10,}$/',
                'max:255',
                Rule::unique('users')->ignore($this->request->get('id')),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
}
