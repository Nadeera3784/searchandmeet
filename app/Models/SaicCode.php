<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaicCode extends Model{

    protected $fillable = [
        'code',
        'name'
    ];

    protected $table = "saic_codes";
}
