<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = "order_items";

    protected $fillable = [
        'purchase_requirement_id',
        'type',
        'required_translator',
        'timeslot_id',
        'package_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function purchase_requirement()
    {
        return $this->belongsTo(PurchaseRequirement::class, 'purchase_requirement_id');
    }

    public function timeSlot()
    {
        return $this->morphOne(Timeslot::class, 'attachable');
    }

    public function agentTime()
    {
        $person = $this->purchase_requirement->person->agent;
        if($person)
        {
            $timezone = $person->timezone->name;
            $timeslot_start =  Carbon::parse($this->timeSlot->start, 'utc')->setTimezone($timezone);
            $timeslot_end =  Carbon::parse($this->timeSlot->end, 'utc')->setTimezone($timezone);
            $day = $timeslot_start->format('d M Y');
            $from = $timeslot_start->format('H:i A');
            $to = $timeslot_end->format('H:i A');
            return "$day from $from to $to $timezone time";
        }
        else {
            return 'No agent attached';
        }
    }

    public function buyerTime()
    {
        $person = $this->purchase_requirement->person;
        $timezone = $person->timezone->name;
        $timeslot_start =  Carbon::parse($this->timeSlot->start, 'utc')->setTimezone($timezone);
        $timeslot_end =  Carbon::parse($this->timeSlot->end, 'utc')->setTimezone($timezone);
        $day = $timeslot_start->format('d M Y');
        $from = $timeslot_start->format('H:i A');
        $to = $timeslot_end->format('H:i A');
        return "$day from $from to $to $timezone time";
    }

    public function supplierTime()
    {
        $person = $this->order->person;
        $timezone = $person->timezone->name;
        $timeslot_start =  Carbon::parse($this->timeSlot->start, 'utc')->setTimezone($timezone);
        $timeslot_end =  Carbon::parse($this->timeSlot->end, 'utc')->setTimezone($timezone);
        $day = $timeslot_start->format('d M Y');
        $from = $timeslot_start->format('H:i A');
        $to = $timeslot_end->format('H:i A');
        return "$day from $from to $to $timezone time";
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class);
    }

    public function cost() {
        $base_cost = DB::table('product_pricing')->where('product_type',  $this->type)->first();
        return $base_cost->price;
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
