<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class PurchaseRequirement extends Model {

    use HasFactory;
    use Hashidable;
    use HasTags;

    protected $fillable = [
        'person_id',
        'product',
        'description',
        'quantity',
        'price',
        'url',
        'pre_meeting_sample',
        'trade_term',
        'payment_term',
        'certification_requirement',
        //'hs_code',
        'metric_id',
        'looking_to_meet',
        'looking_from',
        'category_id',
        'target_purchase_date',
        'purchase_policy',
        'purchase_frequency',
        'warranties_requirement',
        'safety_standard',
        'requirement_specification_id',
        'status',
        'slug',
        'suffix',
        'added_by_agent'
    ];

    protected $table = 'purchase_requirements';

    public function getPurchaseVolumeAttribute()
    {
        if($this->price && $this->quantity)
        {
            if($this->person->source === 'api')
            {
                return $this->price;
            }
            else
            {
                return $this->price * $this->quantity;
            }
        }

        return 0;
    }

    public function getTitleAttribute(){
        
        return $this->product . " " . $this->suffix;
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id')->withTrashed();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'purchase_requirement_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function metric()
    {
        return $this->belongsTo(Metric::class, 'metric_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'purchase_requirement_images');
    }

    public function requirementSpecificationDocument()
    {
        return $this->belongsTo(File::class, 'requirement_specification_id');
    }

    public function isInWatchlist()
    {
        if(auth('person')->check() && auth('person')->user()->watchList)
        {
            return auth('person')->user()->watchList->items->contains('purchase_requirement_id', $this->id);
        }

        return false;
    }

    public function addedByAgent()
    {
        return $this->belongsTo(User::class, 'added_by_agent');
    }

    public function timeslots()
    {
        return $this->morphMany(Timeslot::class, 'attachable');
    }

    public function hs_codes(){
        return $this->hasMany(PurchaseRequirementsHsCode::class, 'purchase_requirement_id');
    }


}
