<?php

namespace App\Repositories\Country;

use App\Models\Country;
use App\Models\PricePercentage;

class CountryPriceEloquentRepository implements CountryPriceRepositoryInterface
{
    public function getAll()
    {
        return PricePercentage::with('country')->get();
    }

    public function getByCountry($country_id)
    {
        $country = Country::find($country_id);
        return $country->pricePercentage;
    }

    public function updateData($country_id, $percentage, $type)
    {
        $country_percentage = PricePercentage::where('country_id', $country_id);
        if($type === 'origin')
        {
            $country_percentage->update([
                'percentage' => $percentage,
            ]);
        }
        else if($type === 'viewer')
        {
            $country_percentage->update([
                'viewer_percentage' => $percentage,
            ]);
        }

        return $country_percentage;
    }
}