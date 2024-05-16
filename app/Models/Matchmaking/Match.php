<?php

namespace App\Models\Matchmaking;

use App\Models\Country;
use App\Models\Person;
use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory, Hashidable;

    protected $table = "matches";

    protected $fillable = [
        'person_id',
        'notification_status',
        'type',
        'initiator'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'match_id');
    }

}
