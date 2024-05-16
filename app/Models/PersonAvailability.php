<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonAvailability extends Model
{
    use HasFactory;

    protected $table = "people_availabilities";

    protected $fillable = [
        'person_id',
        'today',
        'tomorrow',
        'this_week',
        'this_month',
        'next_month'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
