<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use Hashidable;

    protected $fillable = [
        'person_id',
        'status'
    ];

    protected $table = "orders";

	public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function purchase_requirement()
    {
        return $this->belongsToMany(PurchaseRequirement::class, OrderItem::class, 'order_id', 'purchase_requirement_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
