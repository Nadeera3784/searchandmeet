<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsCode extends Model{

    protected $fillable = [
        'code',
        'name',
        'section'
    ];

    protected $table = "hs_codes";
}
