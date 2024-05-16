<?php

namespace App\Models;

use App\Services\DateTime\TimeZoneService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;

    protected $table = "timeslots";

    protected $fillable = [
        'start',
        'end'
    ];

    protected $dates = [
        'start',
        'end'
    ];

    public function purchase_requirement() {
        return $this->belongsTo(PurchaseRequirement::class);
    }

    public function orderItem() {
        return $this->hasOne(OrderItem::class);
    }

    public function appointment_time(){
        $timezoneService = new TimeZoneService;

        $user = null;
        if(auth('person')->check())
        {
            $user = auth('person')->user();
        }
        else if(auth('agent')->check())
        {
            $user = auth('agent')->user();
        }

        $day = $timezoneService->localTime($user, $this->start, 'd D M Y');
        $start = $timezoneService->localTime($user, $this->start, 'H:i A');
        $end = $timezoneService->localTime($user, $this->end, 'H:i A');

        if($user)
        {
            return $day. " from " . $start . " to " . $end;
        }
        else
        {
            return $day. " from " . $start . " to " . $end . ' UTC';
        }
    }
}
