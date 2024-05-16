<?php

namespace App\Http\Requests\Agent\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'     => 'required',
            'timezone_id' => 'required',
            'country_id' => 'required',
            'status'   =>'required|in:1,0',
            'profile_picture' => 'nullable|image',
            'profile_picture_changed' => 'required|in:true,false'
        ];
    }

    public function messages()
    {
        return [];
    }
}
