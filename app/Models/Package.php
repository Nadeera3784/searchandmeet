<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, Hashidable;

    protected $fillable = [
        'title',
        'person_id',
        'allowed_meeting_count',
        'quota_used',
        'discount_rate',
        'country_id',
        'status',
        'payment_link',
        'invoice_id',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
