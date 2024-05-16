<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingPool extends Model{

    protected $table = "meeting_pools";

    protected $fillable = [
        'order_id',
        'buyer_id',
        'supplier_id',
        'agent_id',
        'is_buyer_attended',
        'is_supplier_attended',
        'is_agent_attended'
    ];
}