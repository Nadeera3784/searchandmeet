<?php

namespace App\Http\Requests\Agent\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductPricingRequest extends FormRequest
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
            'product_type' => 'required',
            'price' => 'required|integer|min:1',
        ];
    }
}
