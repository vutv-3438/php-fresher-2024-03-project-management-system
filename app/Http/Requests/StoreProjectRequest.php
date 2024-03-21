<?php

namespace App\Http\Requests;

use App\Rules\DateGreaterThanCurrent;
use App\Rules\StartDateGreaterThanEnddate;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date', new DateGreaterThanCurrent()],
            'end_date' => [
                'nullable',
                'date',
                new DateGreaterThanCurrent(),
                new StartDateGreaterThanEnddate($this->request->get('start_date')),
            ],
        ];
    }
}
