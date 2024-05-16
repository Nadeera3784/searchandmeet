<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" =>  $this->getRouteKey(),
            "person_id" => $this->person_id,
            "country_id" => $this->country_id,
            "type_id " => $this->type_id,
            "company_type_id" => $this->company_type_id,
            "name" => $this->name,
            "current_importer" => $this->current_importer,
            "phone" => $this->phone,
            "website" => $this->website,
            "linkedin" => $this->linkedin,
            "facebook" => $this->facebook,
            "founded_year" => $this->founded_year,
            "HQ" => $this->HQ,
            "employee_count" => $this->employee_count,
            "annual_revenue" => $this->annual_revenue,
            "sic_code" => $this->sic_code,
            "naics_code" => $this->naics_code,
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
        ];
    }
}
