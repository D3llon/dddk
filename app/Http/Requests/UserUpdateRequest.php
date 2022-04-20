<?php

namespace App\Http\Requests;

use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends UserUpdateCrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->request->get('id') ?? request()->route('id');

        return [
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
