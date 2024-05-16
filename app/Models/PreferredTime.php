<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferredTime extends Model
{
    use HasFactory;

    protected $table = "preferred_times";

    protected $fillable = [
        'time',
    ];

}
