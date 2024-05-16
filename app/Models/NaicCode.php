<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaicCode extends Model{

    protected $fillable = [
        'code',
        'name'
    ];

    protected $table = "naic_codes";
}
