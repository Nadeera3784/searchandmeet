<?php

namespace App\Http\Requests\Web\Meeting;

use App\Enums\Order\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;

class JoinMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $meeting = $this->route('meeting');
        if($meeting->orderItem->order->status === OrderStatus::Completed)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
