<?php

namespace App\Models;

use App\Enums\Order\OrderStatus;
use App\Enums\ProspectType;
use App\Models\Matchmaking\Match;
use App\Services\Schedule\ScheduleServiceInterface;
use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class Person extends Authenticatable
{
    use HasFactory, Notifiable, Billable, Hashidable, SoftDeletes;

    protected $guard = 'person';
    public $type = 'person';

    protected static function booted()
    {
        static::created(function ($model) {
            $model->watchList()->create();
            $model->createAsStripeCustomer();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'timezone_id',
        'country_id',
        'phone_number',
        'agent_id',
        'looking_for',
        'phone_verified_at',
        'email_verified_at',
        'designation',
        'status',
        'source',
        'marketing_opt_in',
        'agent_id',
        'looking_for_category',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function formattedPhoneNumber()
    {
        if($this->country && $this->phone_number)
        {
            return '+'.$this->country->phonecode . $this->phone_number;
        }

        return null;
    }

    public function routeNotificationForTwilio()
    {
        return $this->formattedPhoneNumber();
    }

    public function nextAvailable(){
        $scheduleService = app()->make(ScheduleServiceInterface::class);
        return $scheduleService->getNextAvailableTimeslot($this);
    }

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function purchase_requirements()
    {
        return $this->hasMany(PurchaseRequirement::class);
    }

    public function accessible_purchase_requirements()
    {
        $purchase_requirements = PurchaseRequirement::with(['person', 'orderItems']);
        $id = $this->id;
        $purchase_requirements->whereHas('orderItems.order', function($q) use ($id) {
            $q->where('person_id', $id);
            $q->where('status', OrderStatus::Completed);
        });

        $purchase_requirements->orWhere('person_id', $id);
        return $purchase_requirements->get();
    }

    public function reserved_purchase_requirements()
    {
        $purchase_requirements = PurchaseRequirement::with(['person', 'orderItems']);
        $id = $this->id;
        $purchase_requirements->whereHas('orderItems.order', function($q) use ($id) {
            $q->where('person_id', $id);
            $q->where('status', OrderStatus::Pending);
        });

        $purchase_requirements->orWhere('person_id', $id);
        return $purchase_requirements->get();
    }

    public function generalizedType()
    {
        $suppliers = [
            ProspectType::Buyers,
            ProspectType::Customers,
            ProspectType::Owners,
            ProspectType::Importers,
            ProspectType::Resellers,
            ProspectType::Procurement_Managers,
            ProspectType::Purchasing_Managers,
            ProspectType::Consultant,
            ProspectType::Supply_Chain,
        ];

        $buyers = [
            ProspectType::Supplier,
            ProspectType::Vendor,
            ProspectType::Manufacturer,
            ProspectType::Exporters,

        ];

        if(in_array($this->looking_for, $suppliers)) return 'supplier';
        if(in_array($this->looking_for, $buyers)) return 'buyer';
        return null;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function preferredTimes()
    {
        return $this->belongsToMany(PreferredTime::class, 'person_preferred_times', 'person_id', 'preferred_time_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function lookingForCategory(){
        return $this->belongsTo(Category::class, 'looking_for_category');
    }

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class, 'timezone_id');
    }

    public function preferredLanguages()
    {
        return $this->morphToMany(Language::class, 'languagable');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function watchList()
    {
        return $this->hasOne(WatchList::class, 'person_id');
    }

    public function tags()
    {
        return $this->morphToMany(Language::class, 'attachable');
    }

    public function scopeProspectTypeDescription(){

        $prospect_type = '';

        if(!empty($this->looking_for)){
            if (array_key_exists($this->looking_for, ProspectType::asSelectArray())) {
                $prospect_type = ProspectType::asSelectArray()[$this->looking_for];
            }
        }

        return $prospect_type;

    }

    public function schedule(){
        return $this->hasOne(Schedule::class);
    }

    public function availability_index(){
        return $this->hasOne(PersonAvailability::class);
    }

    public function packages(){
        return $this->hasMany(Package::class);
    }

    public function matches(){
        return $this->hasMany(Match::class);
    }
}
