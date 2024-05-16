<?php

namespace App\Http\Requests\Agent\PurchaseRequirement;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequirement extends FormRequest
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
            'person_id'                => 'sometimes|required',

            'category_id'               => 'required',
            'metric_id'                 => 'required',
            'product'                   => 'required',
            'description'               => 'required',
            'quantity'                  => 'required|integer|min:0',
            'price'                     => 'required|integer|min:0',
            'url'                       => 'url|nullable|max:200',
            'pre_meeting_sample'        => 'string|nullable',
            'looking_to_meet' => 'string|nullable',
            'looking_from' => 'string|nullable',
            'payment_term' => 'string|nullable',
            'trade_term' => 'string|nullable',
            'certification_requirement' => 'string|nullable',
            'hs_code'                   => 'array|nullable',
            'target_purchase_date'      => 'date|nullable',
            'purchase_policy'           => 'string|nullable',
            'purchase_frequency'        => 'string|nullable',
            'warranties_requirement'    => 'string|nullable',
            'safety_standard'           => 'string|nullable',
            'tags'                      => 'nullable',
            'images.*' => 'nullable|image',
            'images_changed' => 'required|string',
            'requirement_specification' => 'nullable|mimes:doc,pdf,docx',
            'requirement_specification_changed' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required_without_all' => 'The :attribute field is required.',
            'email.required_without_all' => 'The :attribute field is required.',
            'msisdn.required_without_all' => 'The :attribute field is required.',
            'designation.required_without_all' => 'The :attribute field is required.',
            'country_id.required_without_all' => 'The :attribute field is required.',
            'business_type_id.required_without_all' => 'The :attribute field is required.',
            'phone.required_without_all' => 'The :attribute field is required.',
            'address.required_without_all' => 'The :attribute field is required.',
            'city.required_without_all' => 'The :attribute field is required.',
            'state.required_without_all' => 'The :attribute field is required.',
        ];
    }
}
