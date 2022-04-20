<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check() || \Auth::id() == request()->route('id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'date_of_birth' => ['sometimes', 'date', 'nullable'],
            'nationality_id' => ['required', 'exists:countries,id'],
            'street' => 'sometimes',
            'city' => 'sometimes',
            'county' => 'sometimes',
            'municipality' => 'sometimes',
            'phone' => 'sometimes',
            'family_membership_parent_id' => ['sometimes', 'exists:users,id'],
            'other_club_membership' => 'sometimes',
            'spz_membership' => 'sometimes',
            'is_senior' => 'accepted',
            'is_handicapped' => 'accepted',
            'dddk_statute' => ['required', 'accepted'],
            'gdpr' => ['required', 'accepted']
        ];
    }
}
