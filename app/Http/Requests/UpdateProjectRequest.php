<?php

namespace App\Http\Requests;

use App\Rules\StartDateGreaterThanEnddate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                new StartDateGreaterThanEnddate($this->request->get('start_date')),
            ],
        ];
    }
}
