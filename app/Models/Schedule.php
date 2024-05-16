<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'default_availability',
        'day_availability',
        'custom_availability',
    ];

    protected $table = "schedules";

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
