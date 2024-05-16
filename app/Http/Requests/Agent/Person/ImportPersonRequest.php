<?php

namespace App\Http\Requests\Agent\Person;

use Illuminate\Foundation\Http\FormRequest;

class ImportPersonRequest extends FormRequest{
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
            'file' => 'required|mimes:xlsx,xls',
        ];
    }

    public function messages()
    {
        return [];
    }
}
