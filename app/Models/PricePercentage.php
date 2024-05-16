<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricePercentage extends Model
{
    use HasFactory;

    protected $table = "country_price";

    protected $fillable = [
        'country_id',
        'percentage',
        'viewer_percentage'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
