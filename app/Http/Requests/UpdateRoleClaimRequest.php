<?php

namespace App\Http\Requests;

use App\Rules\CheckValidClaimTypeRule;
use App\Rules\CheckValidClaimValueRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleClaimRequest extends FormRequest
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
            'claim_type' => ['required', new CheckValidClaimTypeRule()],
            'claim_value' => ['required', new CheckValidClaimValueRule()],
            'role_id' => ['required'],
        ];
    }
}
