<?php

namespace App\Http\Resources;

use App\Enums\Agent\AgentRoles;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->getRouteKey(),
            "name" => $this->name,
            "email" => $this->email,
            "timezone" => $this->timezone->name,
            "country" => $this->country ? $this->country->name : null,
            "status" => $this->status,
            "role" => $this->role->key,
        ];
    }
}
