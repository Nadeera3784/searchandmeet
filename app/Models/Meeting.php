<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory, Hashidable;

    protected $table = "meetings";
    protected $appends = ['participants'];

    protected $fillable = [
        'status',
        'service_id',
        'agent_id',
        'alert_count',
        'translator_id',
        'is_confirmed'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function getTimeSlotAttribute()
    {
        return $this->orderItem->timeSlot;
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function translator()
    {
        return $this->belongsTo(User::class, 'translator_id');
    }

    public function userAlias($user)
    {
       switch(get_class($user))
       {
           case 'App\Models\Person':
               return $this->getRouteKey() . '_person_' . $user->id;
           case 'App\Models\User':
               if($user->id === $this->agent_id)
               {
                   return $this->getRouteKey() . '_agent_' . $user->id;
               }
               else if($user->id === $this->translator_id)
               {
                   return $this->getRouteKey() . '_translator_' . $user->id;
               }
               break;
       }
    }

    public function getParticipantsAttribute(){
        $first_partcipant = $this->orderItem->order->person;
        $second_participant = $this->orderItem->purchase_requirement->person;
        $participants =[
            $first_partcipant,$second_participant
        ];
        return collect($participants);

    }
}
