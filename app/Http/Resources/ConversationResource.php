<?php

namespace App\Http\Resources;

use App\Enums\Agent\AgentRoles;
use App\Enums\Communication\MessageType;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            "users" => $this->users,
            "messages" => MessageResource::collection($this->messages),
        ];
    }
}
