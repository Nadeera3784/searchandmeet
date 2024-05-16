<?php

namespace App\Http\Requests\Agent\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'person_id' => 'required',
            'purchase_requirement_id' => 'required',
            'order_type' => 'required',
            'timeslot' => 'required_unless:order_type,3',
            'requires_translator' => 'nullable',
            'package_id' =>  'nullable',
        ];
    }
}
