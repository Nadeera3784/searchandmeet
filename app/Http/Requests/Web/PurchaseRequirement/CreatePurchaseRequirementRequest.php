<?php

namespace App\Http\Requests\Web\PurchaseRequirement;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequirementRequest extends FormRequest
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
            'person_id'                 => 'sometimes',
            'category_id'               => 'required',
            'metric_id'                 => 'required',
            'product'                   => 'required',
            'description'               => 'required',
            'quantity'                  => 'required|integer|min:0',
            'price'                     => 'required|integer|min:0',
            'url'                       => 'url|nullable|max:200',
            'pre_meeting_sample'        => 'string|nullable',
            'trade_term'                => 'string|nullable',
            'payment_term'              => 'string|nullable',
            'looking_to_meet'           => 'string|nullable',
            'looking_from'              => 'string|nullable',
            'certification_requirement' => 'string|nullable',
            'hs_code'                   => 'array|nullable',
            'target_purchase_date'      => 'date|nullable',
            'purchase_policy'           => 'string|nullable',
            'purchase_frequency'        => 'string|nullable',
            'warranties_requirement'    => 'string|nullable',
            'safety_standard'           => 'string|nullable',

            'tags'                      => 'nullable',
            'images.*' => 'nullable|image',
            'requirement_specification' => 'nullable|mimes:doc,pdf,docx',
        ];
    }

    public function messages()
    {
        return [
            'url.url' => 'Invalid URL format, please make sure the https:// schema is included'
        ];
    }
}
