<?php

namespace App\Http\Requests\Agent\Package;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackageRequest extends FormRequest
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
            'title' => 'required|string',
            'person_id' => 'required',
            'country_id' => 'nullable',
            'allowed_meeting_count' => 'required|numeric',
            'discount_rate' => 'nullable|numeric',
        ];
    }
}
