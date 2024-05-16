<?php

namespace App\Http\Requests\Agent\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'timezone_id' => 'required',
            'country_id' => 'required',
            'role'     => 'required|in:1,2,3,4',
            'status'   => 'required|in:1,0',
        ];
    }
}
