<?php

namespace App\Http\Requests\Agent\Person;

use Illuminate\Foundation\Http\FormRequest;

class CreatePersonRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:people',
            'phone_number' => 'required_with:phone_code_id',
            'phone_code_id' => 'required_with:phone_number',
            'designation' => 'required',
            'languages' => 'required|array|min:1',
            'preferred_times' => 'required|array',
            'looking_for' => 'required|string',
            'timezone_id' => 'required|string',

            'country_id' => 'required',
            'type_id' => 'required',
            'company_type_id' => 'required',
            'business_name' => 'required',
            'current_importer' => 'required|in:yes,no',
            'phone' => 'nullable',
            'founded_year' => 'string|nullable|digits:4|max:' . (date("Y") + 1),
            'HQ' => 'string|nullable',
            'employee_count' => 'integer|nullable',
            'annual_revenue' => 'integer|nullable',
            'sic_code' => 'string|nullable',
            'naics_code' => 'string|nullable',
            'website' => 'url|nullable',
            'linkedin' => 'url|nullable',
            'facebook' => 'url|nullable',
            'instagram' => 'url|nullable',
            'twitter' => 'url|nullable',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',

            'agent_id' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [];
    }
}
