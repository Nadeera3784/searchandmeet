<?php

namespace App\Models\Matchmaking;

use App\Enums\Matchmaking\ItemTypes;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "match_items";

    public $timestamps = false;

    protected $fillable = [
        'match_id',
        'item_id',
        'item_type',
    ];

    public function toObject(){
        if($this->item_type === ItemTypes::PurchaseRequirement)
        {
            return PurchaseRequirement::find($this->item_id);
        }
        else if ($this->item_type === ItemTypes::Person)
        {
            return Person::withTrashed()->find($this->item_id);
        }

        return null;
    }
}
