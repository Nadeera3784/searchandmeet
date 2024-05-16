<?php

namespace App\Http\Requests\Api\PurchaseRequirement;

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
            'person_id' => 'sometimes',
            // new contact
            'name' => 'required_without:person_id',
            'email' => 'required_without:person_id|email|unique:people',
            'phone_number' => 'required_without:person_id|required_with:phone_code_id',
            'phone_code_id' => 'required_without:person_id|required_with:phone_number',
            'designation' => 'required_without:person_id',
            'looking_for' => 'nullable|string',
            'languages' => 'required_without:person_id|array|min:1',
            'timezone_id' => 'required_without:person_id|string',

            // business
            'business_name' => 'required_without:person_id',
            'country_id' => 'required_without:person_id',
            'type_id' => 'required_without:person_id',
            'current_importer' => 'required_without:person_id|in:yes,no',
            'phone' => 'nullable',
            'website' => '',
            'company_type_id' => 'required_without:person_id',
            'linkedin' => '',
            'facebook' => '',
            'founded_year' => 'string|nullable|digits:4|max:' . (date("Y") + 1),
            'HQ' => 'string|nullable',
            'employee_count' => 'string|nullable',
            'annual_revenue' => 'string|nullable',
            'sic_code' => 'string|nullable',
            'naics_code' => 'string|nullable',
            'address' => 'required_without:person_id',
            'city' => 'required_without:person_id',
            'state' => 'required_without:person_id',
            'category_id' => 'required',
            'metric_id' => 'required',
            'product' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'url' => '',
            'pre_meeting_sample' => '',
            'target_purchase_date' => 'date|nullable',
            'purchase_policy' => 'string|nullable',
            'purchase_frequency' => 'string|nullable',
            'warranties_requirement' => 'string|nullable',
            'safety_standard' => 'string|nullable',
            'looking_to_meet' => 'string|nullable',
            'looking_from' => 'string|nullable',
            'payment_term' => 'string|nullable',
            'trade_term' => 'string|nullable',
            'certification_requirement' => '',
            'hs_code' => '',
            'images.*' => 'nullable|image',
            'tags' => 'nullable',
            'requirement_specification' => 'nullable|mimes:doc,pdf,docx',
        ];
    }

    public function messages()
    {
        return [
            'name.required_without' => 'The :attribute field is required.',
            'email.required_without' => 'The :attribute field is required.',
            'msisdn.required_without' => 'The :attribute field is required.',
            'designation.required_without' => 'The :attribute field is required.',
            'country_id.required_without' => 'The :attribute field is required.',
            'business_type_id.required_without' => 'The :attribute field is required.',
            'phone.required_without' => 'The :attribute field is required.',
            'address.required_without' => 'The :attribute field is required.',
            'city.required_without' => 'The :attribute field is required.',
            'state.required_without' => 'The :attribute field is required.',
        ];
    }
}
