<?php

namespace App\Http\Requests\Agent\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'default_availability' => 'nullable',
            'day_availability' => 'nullable',
            'custom_availability' => 'nullable'
        ];
    }
}
