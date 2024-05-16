<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Country extends Model
{
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 6400;

    protected $table = 'countries';
    public $timestamps = false;

    public function pricePercentage()
    {
        return $this->hasOne(PricePercentage::class);
    }

    public function people(){
        return $this->hasMany(Person::class);
    }
}
