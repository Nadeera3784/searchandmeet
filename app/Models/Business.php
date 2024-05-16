<?php

namespace App\Models;

use App\Enums\Business\BusinessType;
use App\Enums\Business\CompanyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'company_type_id',
        'name',
        'current_importer',
        'phone',
        'website',
        'linkedin',
        'facebook',
        'instagram',
        'twitter',
        'website',
        'founded_year',
        'HQ',
        'employee_count',
        'annual_revenue',
        'sic_code',
        'naics_code',
        'address',
        'city',
        'state',
        'country_id',
    ];

   	public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function type()
    {
        return BusinessType::fromValue($this->type_id);
    }

    public function companyType()
    {
        return CompanyType::fromValue($this->company_type_id);
    }

    public function complete_address(){
   	    return $this->address . ', ' . $this->city . ', ' . $this->state . ', ' . $this->country->name;
    }

    public function saic_code(){
        return $this->belongsTo(SaicCode::class, 'sic_code');
    }

    public function naic_code(){
        return $this->belongsTo(NaicCode::class, 'naics_code');
    }

}
