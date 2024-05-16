<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'person_id',
        'processor',
        'processor_reference',
        'amount',
        'receipt_url',
        'status',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
