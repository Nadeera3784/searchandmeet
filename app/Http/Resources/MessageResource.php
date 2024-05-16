<?php

namespace App\Http\Resources;

use App\Enums\Agent\AgentRoles;
use App\Enums\Communication\MessageType;
use App\Enums\Order\OrderItemType;
use App\Models\Order;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            "user" => $this->user,
            "content" => $this->getContent($this->content, $this->type),
            "type" => $this->type,
            "timestamp" => $this->timestamp
        ];
    }

    public function getContent($content, $type)
    {
        switch ($type) {
            case MessageType::Text:
                return ['text' => $content];
            case MessageType::Requirement:
                $id = \Hashids::connection(PurchaseRequirement::class)->decode($content)[0] ?? null;
                $pr = PurchaseRequirement::find($id);
                if ($pr) {
                    return [
                        'product' => $pr->product,
                        'link' => route('agent.purchase_requirements.show', $pr->getRouteKey()),
                        'person_email' => $pr->person->email,
                    ];
                }
                return [];
            case MessageType::Person:
                $id = \Hashids::connection(Person::class)->decode($content)[0] ?? null;
                $person = Person::find($id);
                if ($person) {
                    return [
                        'name' => $person->name,
                        'email' => $person->email,
                        'link' => route('agent.people.show', $person->getRouteKey()),
                    ];
                }
                return [];
            case MessageType::Order:
                $id = \Hashids::connection(Order::class)->decode($content)[0] ?? null;
                $order = Order::find($id);
                if ($order) {
                    return [
                        'id' => $order->getRouteKey(),
                        'product' => $order->items[0]->purchase_requirement->product,
                        'type' => OrderItemType::getDescription($order->items[0]->type),
                        'link' => route('agent.order.show', $order->getRouteKey())
                    ];
                }
                return [];
        }
    }
}


