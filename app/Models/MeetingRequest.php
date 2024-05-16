<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRequest extends Model
{
    use HasFactory, Hashidable;

    protected $table = "meeting_requests";

    protected $fillable = [
        'message',
        'purchase_requirement_id',
        'day_availability',
        'default_availability',
        'recommend_similar_products',
        'person_id',
        'status'
    ];

    protected $casts = [
        'default_availability' => 'json',
        'day_availability' => 'json',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function purchase_requirement()
    {
        return $this->belongsTo(PurchaseRequirement::class, 'purchase_requirement_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function custom_timeslot()
    {
        return $this->morphOne(Timeslot::class, 'attachable');
    }
}
