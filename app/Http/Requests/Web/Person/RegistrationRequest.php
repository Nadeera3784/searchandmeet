<?php

namespace App\Http\Requests\Web\Person;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'unique:people,email'],
            'phone_number' => ['required_with:phone_code_id','numeric','nullable'],
            'phone_code_id' => ['required_with:phone_number'],
            'looking_for' => ['required'],
            'timezone_id' => ['required'],
            'languages' => 'required|array|min:1',
            'opt_in_marketing' => ['nullable'],
            'policy_check' => ['required','in:on'],
            'category_id' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'policy_check.required' => 'Please accept the terms & conditions and the privacy policy before continuing with the registration',
            'policy_check.in' => 'Please accept the terms & conditions and the privacy policy before continuing with the registration',
        ];
    }
}
