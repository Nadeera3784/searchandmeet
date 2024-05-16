<?php

namespace App\Http\Requests\Web\Business;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
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
            'type_id'          => 'required',
            'company_type_id'  => 'required',
            'name'             => 'required',
            'current_importer' => 'nullable',
            'phone'            => 'nullable',
            'website'          => 'url|nullable',
            'linkedin'         => 'url|nullable',
            'facebook'         => 'url|nullable',
            'instagram'        => 'url|nullable',
            'twitter'          => 'url|nullable',
            'address'          => 'required|string',
            'city'             => 'required|string',
            'state'            => 'required|string',
            'country_id'       => 'required',
            'founded_year'     => 'string|nullable|digits:4|max:'.(date("Y")+1),
            'HQ'               => 'string|nullable',
            'employee_count'   => 'integer|nullable',
            'annual_revenue'   => 'integer|nullable',
            'sic_code'         => 'string|nullable',
            'naics_code'       => 'string|nullable',
        ];
    }
}