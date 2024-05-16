<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $setupToken = DB::table('password_reset_tokens')->where([
            'person_id' => $this->id,
        ])->first();

        $account_setup_link = null;
        if($setupToken)
        {
            $account_setup_link = route('person.account.setup.show', ['token' => $setupToken->token]);
        }

        return [
            "id" => $this->getRouteKey(),
            "person_id" => $this->id,
            "agent_id" => $this->agent_id,
            "designation" => $this->designation,
            "status" => $this->status,
            "name" => $this->name,
            "email" => $this->email,
            "phone_number" => $this->phone_number,
            "country" => $this->country ? $this->country->name : null,
            "looking_for" => $this->looking_for,
            "timezone_id" => $this->timezone_id,
            "preferred_times" => $this->preferredTimes,
            "timezone" => $this->timezone->name,
            "business" => new BusinessResource($this->business),
            "account_setup_link" => $this->when($account_setup_link !== null, $account_setup_link)
        ];
    }
}
