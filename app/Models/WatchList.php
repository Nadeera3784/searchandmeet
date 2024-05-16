<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    use HasFactory;

    protected $table = "watch_lists";

    public function items()
    {
        return $this->hasMany(WatchListItem::class, 'watch_list_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
