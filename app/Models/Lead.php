<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory, Hashidable;

    protected $table = "leads";

    protected $fillable = [
        'person_name',
        'email',
        'phone',
        'website',
        'country_id',
        'category_id',
        'business_name',
        'looking_for',
        'inquiry_message',
        'status',
        'agent_id'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function available_timeslots()
    {
        return $this->morphMany(Timeslot::class, 'attachable');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
