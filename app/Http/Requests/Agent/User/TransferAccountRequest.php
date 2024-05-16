<?php

namespace App\Http\Requests\Agent\User;

use Illuminate\Foundation\Http\FormRequest;

class TransferAccountRequest extends FormRequest
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
            'agent_id' => 'sometimes',
            'delete_account' => 'string',
            'name'     => 'required_without:agent_id',
            'email' => 'required_without:agent_id|email|unique:users|confirmed|nullable',
            'timezone_id' => 'required_without:agent_id',
            'country_id' => 'required_without:agent_id',
        ];
    }

    public function messages()
    {
        return [];
    }
}
