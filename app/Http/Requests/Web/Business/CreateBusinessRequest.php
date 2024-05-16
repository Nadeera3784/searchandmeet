<?php

namespace App\Http\Requests\Web\Business;

use Illuminate\Foundation\Http\FormRequest;

class CreateBusinessRequest extends FormRequest
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
            'person_id'        => 'required',
            'type_id'          => 'required',
            'name'             => 'required',
            'current_importer' => 'required',
            'phone'            => 'nullable',
            'website'          => 'url|nullable',
            'linkedin'         => 'url|nullable',
            'facebook'         => 'url|nullable',
            'instagram'        => 'url|nullable',
            'twitter'          => 'url|nullable',
            'address'          => 'string|nullable',
            'employee_count' => 'integer|nullable',
            'annual_revenue' => 'integer|nullable',
            'city'             => 'string|nullable',
            'state'            => 'string|nullable',
            'country_id'       => 'required',
        ];
    }
}
