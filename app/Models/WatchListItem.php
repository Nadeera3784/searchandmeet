<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_requirement_id',
        'watch_list_id'
    ];

    public function purchase_requirement()
    {
        return $this->belongsTo(PurchaseRequirement::class, 'purchase_requirement_id');
    }
    public function watchlist()
    {
        return $this->belongsTo(WatchList::class, 'watch_list_id');
    }
}
