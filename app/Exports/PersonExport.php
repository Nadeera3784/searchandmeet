<?php

namespace App\Exports;

use App\Models\Person;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonExport implements FromQuery, WithHeadings, WithMapping{
    
    use Exportable;

     public function __construct($name, $email, $looking_for){
        $this->name = $name;
        $this->email = $email;
        $this->looking_for = $looking_for;
    }

    public function map($person) : array {
         $person_attr  = [
             $person->agent_id,
             $person->designation,
             $person->status,
             $person->timezone_id,
             $person->name,
             $person->email,
             $person->country_id,
             $person->phone_number,
             $person->phone_verified_at,
             $person->email_verified_at,
             $person->looking_for,
             $person->password,
             $person->remember_token,
             $person->created_at,
             $person->updated_at,
             $person->stripe_id,
             $person->pm_type,
             $person->pm_last_four,
             $person->source,
             $person->marketing_opt_in,
             $person->deleted_at,
         ];

         if($person->business)
         {
             $business_attr  = [
                 $person->business->country_id,
                 $person->business->type_id,
                 $person->business->company_type_id,
                 $person->business->name,
                 $person->business->current_importer,
                 $person->business->phone,
                 $person->business->website,
                 $person->business->linkedin,
                 $person->business->facebook,
                 $person->business->founded_year,
                 $person->business->HQ,
                 $person->business->employee_count,
                 $person->business->annual_revenue,
                 $person->business->sic_code,
                 $person->business->naics_code,
                 $person->business->address,
                 $person->business->city,
                 $person->business->state,
                 $person->business->created_at,
                 $person->business->deleted_at
             ];
             $person_attr = array_merge($person_attr, $business_attr);
         }

        return $person_attr;
    }

    public function headings() : array {
        return [
           'agent_id',
           'designation',
           'status',
           'timezone_id',
           'name',
           'email',
           'country_id',
           'phone_number',
           'phone_verified_at',
           'email_verified_at',
           'looking_for',
           'password',
           'remember_token',
           'created_at',
           'updated_at',
           'stripe_id',
           'pm_type',
           'pm_last_four',
           'trial_ends_at',
           'source',
           'marketing_opt_in',
           'deleted_at',
           'country_id ',
           'type_id',
           'company_type_id',
           'name',
           'current_importer',
           'phone',
           'website',
           'linkedin',
           'facebook',
           'founded_year',
           'HQ',
           'employee_count',
           'annual_revenue',
           'sic_code',
           'naics_code',
           'address',
           'city',
           'state',
           'created_at',
           'deleted_at'


        ];
    }

    public function query(){

        $person = Person::query()->with('business'); 

        if($this->name){
            $person->where('name', $this->name); 
        }

        if($this->email){
           $person->where('email', $this->email); 
        }

        if($this->looking_for){
           $person->where('looking_for', $this->looking_for); 
        }

        return $person;
    }
}