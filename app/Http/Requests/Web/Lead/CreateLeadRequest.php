<?php

namespace App\Http\Requests\Web\Lead;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeadRequest extends FormRequest
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
            'person_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required_with:phone_code|integer',
            'phone_code' => 'required_with:phone|string',
            'website' => 'nullable|url',
            'country_id' => 'nullable|string',
            'looking_for' => 'nullable|string',
            'category_id' => 'nullable|string',
            'business_name' => 'required|string',
            'business_description' => 'nullable|string',
            'inquiry_message' => 'nullable|string',
        ];
    }
}
