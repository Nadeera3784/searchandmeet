<?php

namespace App\Http\Requests\Web\Person;

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
            'name' => 'required|string',
            'phone_number' => 'required_with:phone_code_id|numeric|nullable',
            'phone_code_id' => 'required_with:phone_number',
            'looking_for' => 'required|string',
            'designation' => 'required|string',
            'timezone_id' => 'required',
            'languages' => 'required|array|min:1',
            'category_id' => 'required|string',
        ];
    }
}
