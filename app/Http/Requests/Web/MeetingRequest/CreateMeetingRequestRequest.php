<?php

namespace App\Http\Requests\Web\MeetingRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateMeetingRequestRequest extends FormRequest
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
            'custom_timeslot' => 'nullable',
            'day_availability' => 'nullable',
            'default_availability' => 'nullable',
            'recommend_similar_products' => 'nullable',
            'message' => 'required',
        ];
    }
}
